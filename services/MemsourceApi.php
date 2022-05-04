<?php


namespace App\Services;


use App\Models\Project;
use App\Models\User;

class MemsourceApi
{
    private $token;
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function authenticate($username, $password){
        $url = 'https://cloud.memsource.com/web/api2/v1/auth/login';
        $data = [
            'userName' => $username,
            'password' => $password
        ];
        $data_json = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response, true);
        if (isset($response['errorCode'])){
            echo "ERROR: ". $response['errorDescription'];
            $this->router->handleRequest('login_view');
        }else if (isset($response['user'])){
            $userJson = $response['user'];
            $user = User::deserialize($userJson);
            $user->token = $response['token'];
            $this->token = $response['token'];
            $_SESSION['user'] = $user;
            echo "Success: <br>";
            echo "Logged in as: " . $user. "<br>";
            $this->router->handleRequest('list_projects');
        }
    }

    public function getProjectsList(){
        $projectsUrl = 'https://cloud.memsource.com/web/api2/v1/projects';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $projectsUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: ApiToken ' . $_SESSION['user']->token
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        curl_close($curl);
        $projects = [];
        foreach ($data['content'] as $p){
            $project = Project::deserialize($p);
            array_push($projects, $project);
        }
        return $projects;
    }

    public function getProjectDetails($projectUid){
        $projectsUrl = 'https://cloud.memsource.com/web/api2/v1/projects/'.$projectUid;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $projectsUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: ApiToken ' . $_SESSION['user']->token
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        curl_close($curl);
        return $data;
    }
}