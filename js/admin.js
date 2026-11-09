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
    btnYes.addEventListener('click', function() {
        if (formKODeslani) {
            dialog.close();         // Zavření okna
            formKODeslani.submit(); // Definitivní odeslání uloženého formuláře na server
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

});