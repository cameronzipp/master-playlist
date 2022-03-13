<?php

// Turn on output buffering
ob_start();

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require autoload file
require_once('vendor/autoload.php');

// Start the session
session_start();
//var_dump($_SESSION);

//create instance of the base class
$f3 = Base::instance();
$con = new Controller($f3);
$dataLayer = new DataLayer();

//define default route
$f3->route('GET /', function($f3, $params) {
    global $con;
    $con->home();
});

//define login route
$f3->route('GET|POST /login', function($f3, $params) {
    global $con;
    $con->login();
});

//define register route
$f3->route('GET|POST /register', function($f3, $params) {
    global $con;
    $con->register();
});

//define logout route
$f3->route('GET /logout', function($f3, $params) {
    global $con;
    $con->logout();
});

//run fat-free
$f3->run();

ob_flush();
