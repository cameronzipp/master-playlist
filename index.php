<?php

// Turn on output buffering
ob_start();

//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();
var_dump($_SESSION);

//require autoload file
require_once('vendor/autoload.php');
require('model/data-layer.php');
require('model/validation-functions.php');
require('model/functions.php');

//create instance of the base class
$f3 = Base::instance();

//define default route
$f3->route('GET /', function($f3, $params) {
    $view = new Template();
    echo $view->render('views/home.html');
});

//define login route
$f3->route('GET|POST /login', function($f3, $params) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // if there is a username
        if (!empty($_POST['username'])) {
            $password = getPassword($_POST['username']);
            // if there is no saved "account"
            if ($password === 0) {
                $f3->set('errors["username"]', 'Could not find your Master Playlist Account.');
            } else {
                // if there is a password
                if (!empty($_POST['password'])) {
                    if ($_POST['password'] === $password) {
                        $_SESSION['logged'] = $_POST['username'];
                    } else {
                        $f3->set('errors["password"]', 'Password was wrong. Please try again.');
                    }
                } else {
                    $f3->set('errors["password"]', 'Enter a password.');
                }
            }
        } else {
            $f3->set('errors["username"]', 'Enter a username.');
        }

        $f3->set('temp_username', $_POST['username']);
        $f3->set('temp_password', $_POST['password']);

        if (empty($f3->get('errors'))) {
            $f3->reroute('/');
        }
    }

    $view = new Template();
    echo $view->render('views/login.html');
});

//define register route
$f3->route('GET /register', function($f3, $params) {
    $view = new Template();
    echo $view->render('views/register.html');
});

//define logout route
$f3->route('GET /logout', function($f3, $params) {
    if (!empty($_SESSION['logged'])) {
        unset($_SESSION['logged']);
    }
    $f3->reroute('/login');
});

//run fat-free
$f3->run();

ob_flush();
