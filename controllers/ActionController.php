<?php

namespace App\Controller;

use App\Services\MemsourceApi;

Class ActionController {
    public function render($file) {
        include '' . $file .'.php';
    }
    public function index() {
        include 'index.php';
    }

    public function authenticate_user()
    {
        if (isset($_POST['username']) && isset($_POST['password'])){
            $_SESSION['memsource_api']->authenticate($_POST['username'], $_POST['password']);
        }
    }

    public function login_view()
    {
        $this->render('views/authenticate');
    }

    public function list_projects(){
        $_SESSION['memsource_api']->getProjectsList();
        $this->render('views/list_projects');
    }

    public function project_details()
    {
        if (isset($_GET['projectId'])) {
            $data = $_SESSION['memsource_api']->getProjectDetails($_GET['projectId']);
        }
        $d = json_encode($data);
        echo $d;
    }
}
