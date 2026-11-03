<?php
session_start();


header("Access-Control-Allow-Origin: *");           // Povolení CORS pro volání z jiných domén
header("Content-Type: text/csv; charset=UTF-8");        // Říkáme prohlížeči: "Tohle není HTML, ale CSV dokument"

if (!isset($_SESSION['api_users'])) {       //testovací data
    $_SESSION['api_users'] = [
        1 => ['id' => 1, 'name' => 'Jan', 'surname' => 'Novak'],
        2 => ['id' => 2, 'name' => 'Lukas', 'surname' => 'Bittner']
    ];
}

$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

$endpoint = $urlParts[0] ?? '';             // např. 'get', 'post', 'delete'
$id = $urlParts[1] ?? null;                 // ID uživatele
$method = $_SERVER['REQUEST_METHOD'];           // Zjistíme HTTP metodu (GET nebo POST)


function outputCSV($data) {
    
    $output = fopen("php://output", "w");           // Předvyplníme si pár uživatelů, ať máme co testovat
    
    fputcsv($output, ['id', 'name', 'surname']);        // Zapíšeme hlavičku CSV tabulky
    
    if (empty($data)) {
        fclose($output);
        exit;
    }
    
    // Pokud posíláme jen 1 uživatele, nemá v sobě další pole, tak musíme poznat rozdíl
    if (isset($data['id'])) {
        fputcsv($output, [$data['id'], $data['name'], $data['surname']]);
    } else {
        // Pokud je uživatelů víc, projdeme je cyklem
        foreach ($data as $user) {
            fputcsv($output, [$user['id'], $user['name'], $user['surname']]);
        }
    }
    
    fclose($output);
    exit; // Ihned ukončíme skript, aby se nepřidaly žádné prázdné znaky
}

if ($endpoint === 'get' && $id === null) {
    // Vstupní bod: get - vrátí seznam všech uživatelů
    outputCSV($_SESSION['api_users']);
    
} elseif ($endpoint === 'get' && $id !== null) {
    // Vstupní bod: get/id - vrátí uživatele s daným id
    if (isset($_SESSION['api_users'][$id])) {
        outputCSV($_SESSION['api_users'][$id]);
    } else {
        http_response_code(404);         // Kód 404 Not Found
        echo "id,name,surname\nchyba,uzivatel,nenalezen";
    }
    
} elseif ($endpoint === 'post' && $method === 'POST') {
    // Vstupní bod: post - uloží uživatele (data z HTTP POST)
    $newId = $_POST['id'] ?? null;
    if ($newId) {
        $_SESSION['api_users'][$newId] = [
            'id' => $newId,
            'name' => $_POST['name'] ?? '',
            'surname' => $_POST['surname'] ?? ''
        ];
        http_response_code(201); // Kód 201 Created
        echo "id,name,surname\n$newId,uspesne,vytvoren";
    }
    
} elseif ($endpoint === 'update' && $id !== null && $method === 'POST') {
    // Vstupní bod: update/id - změní uživatele s daným id (data z HTTP POST)
    if (isset($_SESSION['api_users'][$id])) {
        // Upravíme data, pokud jsou v POST zadána (jinak necháme původní)
        $_SESSION['api_users'][$id]['name'] = $_POST['name'] ?? $_SESSION['api_users'][$id]['name'];
        $_SESSION['api_users'][$id]['surname'] = $_POST['surname'] ?? $_SESSION['api_users'][$id]['surname'];
        
        http_response_code(200); // 200 OK
        echo "id,name,surname\n$id,uspesne,upraven";
    } else {
        http_response_code(404);
    }
    
} elseif ($endpoint === 'delete' && $id !== null) {
    // Vstupní bod: delete/id - smaže uživatele s daným id
    if (isset($_SESSION['api_users'][$id])) {
        unset($_SESSION['api_users'][$id]); // Vymazání ze session
        http_response_code(200);
        echo "id,name,surname\n$id,uspesne,smazan";
    } else {
        http_response_code(404);
    }
    
} else {
    // Chyták pro neplatné adresy
    http_response_code(400); // 400 Bad Request
    echo "Neznamy nebo nepodporovany API pozadavek.";
}