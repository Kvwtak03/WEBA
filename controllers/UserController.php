<?php
require_once 'controllers/BaseController.php';          // Musíme načíst předka

class UserController extends BaseController{
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function index() {
        $users = $this->userModel->getAllUsers();                   // Controller požádá Model o data
        
        $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;             // Zjištění, zda je uživatel admin (kvůli zobrazení tlačítek)

        $this->render('views/users.php', [                          // Místo require voláme zděděnou metodu render()
            'users' => $users,
            'is_admin' => $is_admin
        ]);
    }
}