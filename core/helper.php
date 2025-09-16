<?php

function view($view, $data = [], $layout = '/layouts/app_admin')
{
    extract($data);

    $viewFile = BASE_PATH . '/views/' . str_replace('.', '/', $view) . '.php';

    if (!file_exists($viewFile)) {
        echo "View not found: $view";
        return;
    }

    ob_start();
    include $viewFile;
    $content = ob_get_clean();

    include BASE_PATH . '/views/' . str_replace('.', '/', $layout) . '.php';
}

function viewRaw($view, $data = [])
{
    extract($data);
    include BASE_PATH . '/views/' . str_replace('.', '/', $view) . '.php';
}

function setFlash($key, $message) {
    $_SESSION[$key] = $message;
}

function getFlash($key) {
    if (!empty($_SESSION[$key])) {
        $msg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $msg;
    }
    return null;
}

function format_tanggal($tanggal, $format = 'd-m-Y')
{
    if (!$tanggal) return '-';

    try {
        return (new DateTime($tanggal))->format($format);
    } catch (Exception $e) {
        return '-';
    }
}


