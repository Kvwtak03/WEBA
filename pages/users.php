<?php
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// když chci přidat nového uživatele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_add']) && $is_admin) {
    $stmt = $pdo->prepare("INSERT INTO users (jmeno, prijmeni, email, telefon, pracovna, heslo, is_admin) 
                           VALUES (:jmeno, :prijmeni, :email, :telefon, :pracovna, :heslo, :is_admin)");
    
    $stmt->execute([
        'jmeno' => $_POST['jmeno'],
        'prijmeni' => $_POST['prijmeni'],
        'email' => $_POST['email'],
        'telefon' => $_POST['telefon'],
        'pracovna' => $_POST['pracovna'],
        'heslo' => $_POST['heslo'], 
        'is_admin' => isset($_POST['is_admin']) ? 1 : 0
    ]);
    
    header("Location: index.php?page=users");
    exit;
}

//Když chci smazat uživatele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_delete']) && $is_admin) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $_POST['id']]);
    header("Location: index.php?page=users");
    exit;
}

//Když chci uoravit uživatele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_edit']) && $is_admin) {
    $stmt = $pdo->prepare("UPDATE users SET jmeno = :jmeno, prijmeni = :prijmeni, email = :email, telefon = :telefon, pracovna = :pracovna, is_admin = :is_admin WHERE id = :id");
    $stmt->execute([
        'jmeno' => $_POST['jmeno'],
        'prijmeni' => $_POST['prijmeni'],
        'email' => $_POST['email'],
        'telefon' => $_POST['telefon'],
        'pracovna' => $_POST['pracovna'],
        'is_admin' => isset($_POST['is_admin']) ? 1 : 0,
        'id' => $_POST['id']
    ]);
    header("Location: index.php?page=users");
    exit;
}


// Načtení všech uživatelů z databáze
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
?>

<?php if (isset($_GET['action']) && $_GET['action'] === 'add' && $is_admin): ?>
    <!-- FORMULÁŘ PRO PŘIDÁNÍ -->
    <h2 class="mb-4">Přidat nového uživatele</h2>
    <form action="index.php?page=users" method="POST" class="w-50">
        <input type="hidden" name="action_add" value="1">
        <div class="mb-3"><label class="form-label">Jméno</label><input type="text" name="jmeno" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Příjmení</label><input type="text" name="prijmeni" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Telefon</label><input type="text" name="telefon" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Pracovna</label><input type="text" name="pracovna" class="form-control"></div>
        <div class="mb-3"><label class="form-label">Heslo</label><input type="password" name="heslo" class="form-control" required></div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_admin" class="form-check-input" id="adminCheck">
            <label class="form-check-label" for="adminCheck">Práva administrátora</label>
        </div>
        <button type="submit" class="btn btn-success">Uložit uživatele</button>
        <a href="?page=users" class="btn btn-secondary">Zrušit</a>
    </form>

<?php elseif (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id']) && $is_admin): ?>
    <!-- FORMULÁŘ PRO ÚPRAVU -->
    <?php
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        $u = $stmt->fetch();
        if (!$u) die("Uživatel nenalezen.");
    ?>
    <h2 class="mb-4">Upravit uživatele</h2>
    <form action="index.php?page=users" method="POST" class="w-50">
        <input type="hidden" name="action_edit" value="1">
        <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
        
        <div class="mb-3"><label class="form-label">Jméno</label><input type="text" name="jmeno" class="form-control" value="<?php echo htmlspecialchars($u['jmeno']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Příjmení</label><input type="text" name="prijmeni" class="form-control" value="<?php echo htmlspecialchars($u['prijmeni']); ?>" required></div>
        <div class="mb-3"><label class="form-label">E-mail</label><input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($u['email']); ?>" required></div>
        <div class="mb-3"><label class="form-label">Telefon</label><input type="text" name="telefon" class="form-control" value="<?php echo htmlspecialchars($u['telefon']); ?>"></div>
        <div class="mb-3"><label class="form-label">Pracovna</label><input type="text" name="pracovna" class="form-control" value="<?php echo htmlspecialchars($u['pracovna']); ?>"></div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_admin" class="form-check-input" id="adminCheckEdit" <?php echo $u['is_admin'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="adminCheckEdit">Práva administrátora</label>
        </div>
        <button type="submit" class="btn btn-primary">Uložit změny</button>
        <a href="?page=users" class="btn btn-secondary">Zrušit</a>
    </form>

<?php else: ?>
    <!-- VÝPIS VŠECH UŽIVATELŮ (Tabulka) -->
    <h2 class="mb-4">Správa uživatelů</h2>
    <?php if ($is_admin): ?>
        <a href="?page=users&action=add" class="btn btn-primary mb-3">Přidat nového uživatele</a>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Jméno a příjmení</th>
                    <th>E-mail</th>
                    <th>Telefon</th>
                    <th>Pracovna</th>
                    <th>Role</th>
                    <th>Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['jmeno'] . ' ' . $u['prijmeni']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['telefon']); ?></td>
                        <td><?php echo htmlspecialchars($u['pracovna']); ?></td>
                        <td><?php echo $u['is_admin'] ? '<span class="badge bg-danger">Admin</span>' : '<span class="badge bg-secondary">Uživatel</span>'; ?></td>
                        <td>
                            <?php if ($is_admin): ?>
                                <a href="?page=users&action=edit&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary">Upravit</a>
                                <form action="index.php?page=users" method="POST" class="d-inline">
                                    <input type="hidden" name="action_delete" value="1">
                                    <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Opravdu smazat uživatele?');">Smazat</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted small">Nemáte oprávnění</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div class="alert alert-info mt-4">
  Aktuálně přihlášený uživatel: 
  <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>
</div>


