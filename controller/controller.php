<?php

class Controller
{
    private $_f3;

    /**
     * @param $_f3
     */
    public function __construct($_f3)
    {
        $this->_f3 = $_f3;
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // if there is a username
            if (!empty($_POST['username'])) {
                $account = Util::getAccount($_POST['username']);
                // if there is no saved "account"
                if ($account === null) {
                    $this->_f3->set('errors["username"]', 'Could not find your Master Playlist Account.');
                } else {
                    // if there is a password
                    if (!empty($_POST['password'])) {
                        if ($_POST['password'] === $account->getPassword()) {
                            $_SESSION['logged'] = $account;
                        } else {
                            $this->_f3->set('errors["password"]', 'Password was wrong. Please try again.');
                        }
                    } else {
                        $this->_f3->set('errors["password"]', 'Enter a password.');
                    }
                }
            } else {
                $this->_f3->set('errors["username"]', 'Enter a username.');
            }

            if (empty($this->_f3->get('errors'))) {
                $this->_f3->reroute('/');
            }
        }

        $view = new Template();
        echo $view->render('views/login.html');
    }

    public function register()
    {
        $view = new Template();
        echo $view->render('views/register.html');
    }

    public function logout()
    {
        if (!empty($_SESSION['logged'])) {
            unset($_SESSION['logged']);
        }
        $this->_f3->reroute('/login');
    }
}
