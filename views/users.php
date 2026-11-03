


<h2 class="mb-4">Správa uživatelů</h2>

<?php if ($is_admin): ?>
    <a href="?url=users&action=add" class="btn btn-success mb-3">Přidat nového uživatele</a>        <!-- Místo ?page=users používáme náš nový router ?url=users -->
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
                            <a href="?url=users&action=edit&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary">Upravit</a>
                            <form action="index.php?url=users" method="POST" class="d-inline">
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