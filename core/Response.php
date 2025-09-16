<?php

class Response
{
    public function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function redirect(string $path): void
    {
        header("Location: {$path}");
        exit;
    }

    public function status(int $code): void
    {
        http_response_code($code);
    }

    public function send(string $content): void
    {
        echo $content;
        exit;
    }
}
