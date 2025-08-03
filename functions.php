<?php

$appConfig = require "./config/app.php";

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