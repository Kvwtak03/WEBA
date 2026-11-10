<?php
require_once 'controllers/BaseController.php';          // Musíme načíst předka

class UserController extends BaseController{
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }



    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_delete'])) {
            $id = $_POST['id'];
            $this->userModel->deleteUser($id); 
            
            //Pokud je požadavek z AJAXu, pošleme jen čistý JSON potvrzující úspěch a skončíme
            if (isset($_POST['is_ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit; // Zastavíme další běh, nechceme generovat HTML!
            }
            
            header("Location: index.php?url=users&success=1");
            exit;
        }

        if (isset($_GET['action']) && $_GET['action'] === 'add') {
            $this->render('views/user_form.php');
            return; 
        }

        if (isset($_GET['action']) && $_GET['action'] === 'edit') {
            $id = $_GET['id'];
            $userToEdit = $this->userModel->getUserById($id); 
            
            $this->render('views/user_form.php', ['userToEdit' => $userToEdit]);
            return;
        }

        $users = $this->userModel->getAllUsers(); 
        $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1; 

        $this->render('views/users.php', [ 
            'users' => $users,
            'is_admin' => $is_admin
        ]);


        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_save'])) {
            $id = $_POST['id'] ?? null;
            $fullName = trim($_POST['fullName'] ?? '');
            $email = trim($_POST['userEmail'] ?? '');
            $telefon = trim($_POST['telefon'] ?? '');
            $pracovna = trim($_POST['pracovna'] ?? '');
            

            $nameParts = explode(' ', $fullName, 2);
            $jmeno = $nameParts[0];
            $prijmeni = $nameParts[1] ?? ''; 

            if ($id) {
                $this->userModel->updateUser($id, $jmeno, $prijmeni, $email, $telefon, $pracovna);
            } else {
                $this->userModel->addUser($jmeno, $prijmeni, $email, $telefon, $pracovna);
            }

            // Po úspěšném uložení přesměrujeme na tabulku a vyvoláme zelenou notifikaci
            header("Location: index.php?url=users&success=1");
            exit;
        }
    }
}