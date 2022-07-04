<?php


namespace controllers;


use services\SecurityService;
use views\View;

class AuthController
{
    public function main(): void
    {
        $mail = ''; $pass = ''; $error = false;
        if (!empty($_POST))
            if (SecurityService::accountAuth($_POST['mail'], $_POST['pass'])) {
                header('Location:/');
                exit;
            } else {
                $mail = $_POST['mail'];
                $pass = $_POST['pass'];
                $error = true;
            }

        $view = new View('layouts' . DIRECTORY_SEPARATOR . 'auth.php', 'Corporate -> Authorization');
        $view->renderHTML([
            'mail' => $mail,
            'pass' => $pass,
            'error' => $error ? 'true' : 'false'
        ]);
    }
}