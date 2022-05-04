<?php

namespace App\Services;

use App\Controller\ActionController;

class Router
{
    private ActionController $controller;
    public function __construct(ActionController $controller)
    {
        $this->controller = $controller;
    }

    public function handleRequest($action_str){
        switch($action_str) {
            case 'login_view' :
                $this->controller->login_view();
                break;
            case 'authenticate_user' :
                $this->controller->authenticate_user();
                break;
            case 'list_projects' :
                $this->controller->list_projects();
                break;
            case 'project_details' :
                $this->controller->project_details();
                break;
            default:
                $this->controller->index();
                break;
        }
    }

}