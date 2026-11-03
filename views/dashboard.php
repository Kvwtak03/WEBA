<h1 class="h2">Dashboard</h1>
<h2 class="mt-4 mb-3">Poslední přihlášení</h2>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>E-mail</th>
                <th>Čas přihlášení</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($recent_logins)): ?>
                <?php foreach ($recent_logins as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['jmeno']); ?></td>
                        <td><?php echo htmlspecialchars($u['prijmeni']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['last_login']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">Zatím žádná historie přihlášení.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>