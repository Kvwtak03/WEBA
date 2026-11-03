<?php
require_once 'controllers/BaseController.php';

class DashboardController extends BaseController {

    private $userModel; 

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }
    
    
    public function index() {
        $recent_logins = $this->userModel->getRecentLogins();


        $this->render('views/dashboard.php', [
            'recent_logins' => $recent_logins
        ]);
    }
}