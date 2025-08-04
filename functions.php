<?php

$appConfig = require __DIR__ . "/config/app.php";

function dd($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

function asset($path) {
    global $appConfig;

    $project_url = $appConfig['project_url'];

    return $project_url . "/" . $path;
}

function route($path) {
    global $appConfig;

    $project_url = $appConfig['project_url'];

    return $project_url . "/" . $path;
}

function url() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    return $protocol . "://" . $host . $uri;
}

function is_match($url, $pattern) {
    if (strpos($url, $pattern) !== false) {
        return true;
    } else {
        return false;
    }
}