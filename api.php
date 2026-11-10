<?php
session_start();


header("Access-Control-Allow-Origin: *");           // Povolení CORS pro volání z jiných domén
header("Content-Type: application/json; charset=UTF-8");        // Říkáme prohlížeči: "Očekávej moderní strojová data ve formátu JSON"

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


if ($endpoint === 'get' && $id === null) {
    // Vstupní bod: get - vrátí seznam všech uživatelů
    echo json_encode(array_values($_SESSION['api_users']));     // Používáme array_values, abychom z asociativního pole udělali čisté indexované pole pro JavaScript
    exit;
    
} elseif ($endpoint === 'get' && $id !== null) {
    // Vstupní bod: get/id - vrátí uživatele s daným id
    if (isset($_SESSION['api_users'][$id])) {
        echo json_encode($_SESSION['api_users'][$id]);
    } else {
        http_response_code(404);         // Kód 404 Not Found
       echo json_encode(['error' => 'Uživatel nenalezen']);
    }
    exit;
    
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
        echo json_encode(['success' => true, 'message' => 'Uživatel vytvořen', 'id' => $newId]);
    }
    exit;
    
} elseif ($endpoint === 'update' && $id !== null && $method === 'POST') {
    // Vstupní bod: update/id - změní uživatele s daným id (data z HTTP POST)
    if (isset($_SESSION['api_users'][$id])) {
        // Upravíme data, pokud jsou v POST zadána (jinak necháme původní)
        $_SESSION['api_users'][$id]['name'] = $_POST['name'] ?? $_SESSION['api_users'][$id]['name'];
        $_SESSION['api_users'][$id]['surname'] = $_POST['surname'] ?? $_SESSION['api_users'][$id]['surname'];
        
        http_response_code(200); // 200 OK
        echo json_encode(['success' => true, 'message' => 'Uživatel upraven', 'id' => $id]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Uživatel nenalezen']);
    }
    exit;
    
} elseif ($endpoint === 'delete' && $id !== null) {
    // Vstupní bod: delete/id - smaže uživatele s daným id
    if (isset($_SESSION['api_users'][$id])) {
        unset($_SESSION['api_users'][$id]); // Vymazání ze session
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Uživatel smazán', 'id' => $id]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Uživatel nenalezen']);
    }
    
} else {
    // Chyták pro neplatné adresy
    http_response_code(400); // 400 Bad Request
    echo json_encode(['error' => 'Neznamy nebo nepodporovany API pozadavek.']);
    exit;
}