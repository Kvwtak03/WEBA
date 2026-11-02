<?php
session_start();
ob_start(); //Zapnutí vyrovnávací paměti - zachrání nás před "headers already sent" chybou - poradil bot

require_once 'includes/db.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND heslo = :heslo");
    $stmt->execute([
        'email' => $_POST['email'],
        'heslo' => $_POST['password']
    ]);
    
    $user = $stmt->fetch(); 
    
    if ($user) {
        $_SESSION['user'] = $user['jmeno'] . ' ' . $user['prijmeni'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
        $updateStmt->execute(['id' => $user['id']]);
        
        header("Location: index.php");
        exit;
    } else {
        $login_error = "Neplatný e-mail nebo heslo.";
    }
}

if (!isset($_SESSION['user_id'])) {
    include 'pages/login.php';
    exit; 
}





$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$page = basename($page);

$content_file = 'pages/' . $page . '.php';

//(Ochrana proti 404)
if (!file_exists($content_file)) {
    $content_file = 'pages/dashboard.php';
    $page = 'dashboard'; 
}

include 'includes/header.php';
include 'includes/navigation.php';

echo '<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">';
include $content_file;
echo '</main>';
echo '</div></div>'; 

include 'includes/footer.php';
?>