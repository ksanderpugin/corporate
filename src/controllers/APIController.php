<?php


namespace controllers;


class APIController
{
    public function request(string $model, string $command): void
    {
        echo "Model: $model, com: $command\n\n";
    }
}