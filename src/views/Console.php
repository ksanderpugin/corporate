<?php


namespace views;


class Console
{
    private static array $messages = [];

    public static function writeLine(string $message): void
    {
        self::$messages[] = $message;
    }

    public static function getAll(): array
    {
        return self::$messages;
    }
}