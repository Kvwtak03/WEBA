<?php 
// Pomocná proměnná, ať nemusíme všude psát isset()
$isEdit = isset($userToEdit); 
?>

<!-- Dynamický nadpis podle toho, co zrovna děláme -->
<h2 class="mb-4"><?php echo $isEdit ? 'Upravit uživatele' : 'Přidat nového uživatele'; ?></h2>

<div class="card p-4 shadow-sm" style="max-width: 500px;">
    <form id="userForm" action="index.php?url=users" method="POST">
        <input type="hidden" name="action_save" value="1">
        
        <!-- Pokud upravujeme, musíme odeslat i ID uživatele, aby databáze věděla, koho přepsat -->
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?php echo $userToEdit['id']; ?>">
        <?php endif; ?>
        
        <div class="mb-3">
            <label for="fullName" class="form-label">Jméno a příjmení</label>
            <!-- Do atributu value vložíme data z databáze, pokud existují -->
            <input type="text" id="fullName" name="fullName" class="form-control" 
                   value="<?php echo $isEdit ? htmlspecialchars($userToEdit['jmeno'] . ' ' . $userToEdit['prijmeni']) : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="userEmail" class="form-label">E-mail</label>
            <!-- Předvyplnění e-mailu -->
            <input type="email" id="userEmail" name="userEmail" class="form-control"
                   value="<?php echo $isEdit ? htmlspecialchars($userToEdit['email']) : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="userEmail" class="form-label">Telefon</label>
            <!-- Předvyplnění telefonu -->
            <input type="text" id="telefon" name="telefon" class="form-control"
                   value="<?php echo $isEdit ? htmlspecialchars($userToEdit['telefon']) : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="pracovna" class="form-label">Pracovna</label>
            <input type="text" id="pracovna" name="pracovna" class="form-control"
                   value="<?php echo $isEdit ? htmlspecialchars($userToEdit['pracovna']) : ''; ?>">
        </div>

        <div class="d-flex gap-2 mt-4">
            <!-- Dynamický text na tlačítku -->
            <button type="submit" class="btn btn-success">
                <?php echo $isEdit ? 'Uložit změny' : 'Uložit uživatele'; ?>
            </button>
            <a href="?url=users" class="btn btn-secondary">Zrušit a zpět</a>
        </div>
    </form>
</div>


