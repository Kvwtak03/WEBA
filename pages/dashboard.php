<h1 class="pb-3 border-bottom">Dashboard</h1>

<?php
$sql = "SELECT jmeno, prijmeni, email, last_login 
        FROM users 
        WHERE last_login IS NOT NULL 
        ORDER BY last_login DESC 
        LIMIT 10";

$stmt = $pdo->query($sql);
$recent_users = $stmt->fetchAll();
?>

<section class="mt-5">
<h2 class="mb-4">Poslední přihlášení</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>E-mail</th>
                    <th>Čas přihlášení</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent_users)): ?>
                    <tr>
                        <td colspan="4" class="text-center">Zatím se nikdo nepřihlásil.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent_users as $u): ?>
                        <tr>
                            <!--  obrana proti XSS pomocí htmlspecialchars() -->
                            <td><?php echo htmlspecialchars($u['jmeno']); ?></td>
                            <td><?php echo htmlspecialchars($u['prijmeni']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td>
                                <?php 
                                    echo date('d.m.Y H:i:s', strtotime($u['last_login'])); 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>