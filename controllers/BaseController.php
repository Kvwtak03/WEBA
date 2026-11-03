<?php
class BaseController {          // Tato metoda vezme jakýkoliv pohled (view) a obalí ho hlavičkou a patičkou
    public function render($viewPath, $data = []) {

        extract($data);
        
        $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;             // Zjistíme aktuální uživatele pro hlavičku


        require_once 'includes/header.php';
        require_once 'includes/navigation.php';
        
        echo '<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">';
        require_once $viewPath; 
        echo '</main>';
        echo '</div></div>'; 
        
        require_once 'includes/footer.php';
    }
}