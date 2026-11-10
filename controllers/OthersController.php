<?php
require_once 'controllers/BaseController.php';

class OthersController extends BaseController {
    public function index() {
        // Zavolá zděděnou metodu render a obalí pohled hlavičkou a patičkou
        $this->render('views/others.php');
    }
}