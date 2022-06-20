<?php

namespace controllers;

class MainController
{
    public function main() {
        echo "Hello world!";
        \services\UserService::getAll();
    }
}