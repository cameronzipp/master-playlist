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
        $music_json = file_get_contents('music.json');

        $decoded_json = json_decode($music_json, false);

        $decoded_json = array_splice($decoded_json, 0, 25);

//        echo "<pre>";
//        print_r($decoded_json);
//        echo "</pre>";

        $this->_f3->set("songs", $decoded_json);

        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // if there is a username
            if (!empty($_POST['username'])) {
                global $dataLayer;
                $account = $dataLayer->getUserByUsername($_POST['username']);
                // if there is no saved "account"
                if ($account === false) {
                    $this->_f3->set('errors["username"]', 'Could not find your Master Playlist Account.');
                } else {
                    // if there is a password
                    if (!empty($_POST['password'])) {
                        if ($_POST['password'] === $account['password']) {
                            $account = Util::convert_user_array($account);
                            $account->login();
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
            //Initialize input variables
            $username = "";
            $password = "";

            //If the form has been posted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $username = $_POST['username'];
                $password = $_POST['password'];

                //Validate the data
                if(!Validator::validUsername($username)) {
                    //Set an error
                    $this->_f3->set('errors["username"]', '3-16 characters, does not start with a number');
                } else {
                    if (Validator::accountExists($username)) {
                        $this->_f3->set('errors["username"]', 'This username is already taken.');
                    }
                }

                if(!Validator::validPassword($password)) {
                    //Set an error
                    $this->_f3->set('errors["password"]', '10-64 characters, includes any letter/number or !@#$%^&* characters');
                }

                //Redirect user to next page if there are no errors
                if (empty($this->_f3->get('errors'))) {
                    global $dataLayer;
                    $account = new User($username, $password);
                    $account->register();
                    $this->_f3->reroute('/');
                }
            }

            $this->_f3->set('username', $username);
            $this->_f3->set('password', $password);


            $view = new Template();
            echo $view->render('views/register.html');
    }

    public function logout()
    {
        if (!empty($_SESSION['logged'])) {
            $_SESSION['logged']->logout();
        }
        $this->_f3->reroute('/login');
    }
}
