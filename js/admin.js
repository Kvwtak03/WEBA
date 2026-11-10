// Počkáme, až prohlížeč kompletně načte HTML strukturu stránky
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. MAZÁNÍ UŽIVATELŮ (Modální okno) ---
    const dialog = document.getElementById('dialog_delete');
    const btnYes = document.getElementById('button_yes');
    const btnNo = document.getElementById('button_no');
    
    // Zkontrolujeme, zda jsme na stránce s tabulkou (jestli dialog existuje)
    if (dialog && btnYes && btnNo) {
        let formKODeslani = null;
        const deleteForms = document.querySelectorAll('.delete-form');
        
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Okamžitě zastaví výchozí odeslání
            formKODeslani = form;   // Uložení formuláře do paměti pro pozdější odeslání
            dialog.showModal();     // Zobrazení okna ve vrstvě popředí
        });
    });

    // Potvrzení smazání
    btnYes.addEventListener('click',async function() {
        if (formKODeslani) {
            dialog.close();         // Zavření okna

            const formData = new FormData(formKODeslani); // Získáme všechna data z formuláře (id a action_delete)
            formData.append('is_ajax', '1'); // aby PHP vedělo, že se jdná o AJAX

            try {
                    // Moderní asynchronní odeslání pomocí fetch()
                    const response = await fetch(formKODeslani.action, {
                        method: 'POST',
                        body: formData
                    });

                    // Zkontrolujeme, jestli server vrátil úspěšný HTTP status (200-299)
                    if (response.ok) {
                        // ÚSPĚCH: Odstraníme řádek tabulky přímo z DOMu bez obnovení stránky
                        const tr = formKODeslani.closest('tr');
                        if (tr) {
                            tr.remove(); // Vymaže HTML řádek z obrazovky
                        }

                        // Zobrazíme zelenou notifikaci
                        const successAlert = document.getElementById('successAlert');
                        if (successAlert) {
                            successAlert.style.display = "block";
                            setTimeout(() => successAlert.style.display = "none", 3000);
                        }
                    } else {
                        throw new Error('Chyba při mazání na serveru.');
                    }
                } catch (error) {       //catch chytí výpadky internetu i chyby serveru
                    console.error('Nastala chyba:', error);
                    alert("Nepodařilo se smazat uživatele.");
                }

                formKODeslani = null;
        }
    });

    // Zrušení smazání
    btnNo.addEventListener('click', function() {
        formKODeslani = null;
        dialog.close();
        });
    }

    // --- 2. NOTIFIKACE O ÚSPĚCHU (Mizející alert) ---
    const successAlert = document.getElementById('successAlert');

    // Pokud na stránce existuje notifikace, spustíme časovač
    if (successAlert && successAlert.style.display !== 'none') {
        setTimeout(function () {
            successAlert.style.display = "none"; // Po 3000 ms skryje element z toku dokumentu
        }, 3000);
    }



    // --- 3. KLIENTSKÁ VALIDACE FORMULÁŘE (JustValidate) ---
    // Zkontrolujeme, jestli jsme na stránce pro přidání/úpravu uživatele
    if (document.getElementById('userForm')) {
        const validator = new JustValidate('#userForm', {
            errorFieldCssClass: 'is-invalid',
            errorLabelCssClass: 'invalid-feedback',
            errorLabelStyle: { color: '#dc3545' } 
        });

        validator
            .addField('#fullName', [
                { rule: 'required', errorMessage: 'Jméno je povinné.' }, 
                { rule: 'minLength', value: 5, errorMessage: 'Zadejte celé jméno (min. 5 znaků).' } 
            ])
            .addField('#userEmail', [
                { rule: 'required', errorMessage: 'E-mail je povinný.' },
                { rule: 'email', errorMessage: 'Zadejte platný e-mailový formát.' } 
            ])
            .addField('#telefon', [
                { rule: 'required', errorMessage: 'Telefon je povinný.' },
                { rule: 'minLength', value: 9, errorMessage: 'Zadejte platné telefonní číslo.' }
            ])
            .addField('#pracovna', [        //zatím žádné pravidlo
                { rule: 'required', errorMessage: 'Pracovna je povinná.' }
            ])
            .onSuccess(function (event) {
                // Skutečné odeslání do PHP po úspěšné JS validaci
                event.target.submit(); 
            });
    } 

    // --- 4. NAČÍTÁNÍ DAT Z REST API PŘES AJAX ---
    const btnLoadApiUsers = document.getElementById('btnLoadApiUsers');
    const apiUsersList = document.getElementById('apiUsersList');

    if (btnLoadApiUsers && apiUsersList) {        // Tlačítko odposlouchává událost kliknutí a spouští asynchronní funkci
        btnLoadApiUsers.addEventListener('click', async function() {
            
            // Zobrazíme informaci, že stahování probíhá
            apiUsersList.innerHTML = '<li class="list-group-item text-center py-4">Načítám data ze serveru... <div class="spinner-border spinner-border-sm ms-2" role="status"></div></li>';
            
            try {
                // 1. Spuštění požadavku pomocí fetch
                // Voláme endpoint 'get', který vrací seznam všech uživatelů
                const response = await fetch('api.php?url=get');
                
                // 2. Kontrola stavového kódu z hlavičky HTTP (zda je v rozmezí 200-299)
                if (!response.ok) {
                    throw new Error('Chyba komunikace se serverem. Status: ' + response.status);
                }
                
                // 3. Rozbalení balíčku: Překlad přijatého textu do JS pole objektů
                const users = await response.json();
                
                // 4. Manipulace s DOMem: Vykreslení přijatých dat
                apiUsersList.innerHTML = ''; // Nejprve vyprázdníme seznam
                
                if (users.length === 0) {
                    apiUsersList.innerHTML = '<li class="list-group-item text-center py-4">Zatím neexistují žádní uživatelé.</li>';
                } else {
                    // Pomocí cyklu forEach projdeme získaná data a pro každý záznam vložíme HTML element
                    users.forEach(function(user) {
                        apiUsersList.innerHTML += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${user.name} ${user.surname}</strong>
                                    <br><small class="text-muted">ID: ${user.id}</small>
                                </div>
                            </li>
                        `;
                    });
                }
                
            } catch (error) {
                //catch() odchytí rozbitý JSON, výpadky spojení i námi vyvolané chyby
                console.error('Nastala chyba při stahování dat:', error);
                apiUsersList.innerHTML = '<li class="list-group-item text-center text-danger py-4">Nepodařilo se načíst data z API.</li>';
            }
        });
    }

});