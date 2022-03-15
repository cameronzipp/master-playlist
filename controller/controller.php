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
        global $dataLayer;

        if (empty($_SESSION['logged'])) {
            $playlist = new Playlist("Example Playlist", Publicity::PUBLIC());
            $songs = array_map(function ($item) {return $item['song']['id'];}, $dataLayer->getSongs(50));
            $playlist->setSongIds($songs);
        } else {
            $playlist = $_SESSION['logged']->getPlaylist();
        }

        $this->_f3->set("playlist", $playlist);
        $this->_f3->set("songs", $dataLayer->getSongsFromIds($playlist->getSongIds()));

        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function search()
    {
        if (empty($_SESSION['logged'])) {
            $this->_f3->reroute("/login");
        }

        global $dataLayer;

        $playlist = new Playlist("All Songs", Publicity::PUBLIC());
        $songs = array_map(function ($item) {return $item['song']['id'];}, $dataLayer->getSongs());
        $playlist->setSongIds($songs);

        $this->_f3->set("playlist", $playlist);
        $this->_f3->set("songs", $dataLayer->getSongsFromIds($playlist->getSongIds()));

        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function api()
    {
        if (empty($_SESSION['logged'])) {
            $this->_f3->reroute('/login');
        }

        $actions = ["add", "remove"];
        $params = $this->_f3->get("PARAMS");

        $action = $params['action'];
        $song_id = $params['song_id'];

        if (empty($song_id)) {
            die("Invalid ID: " . $song_id);
        }
        if (empty($action) || !in_array($action, $actions)) {
            $str = "Invalid action: " . $action . "<br>";
            $str .= "Available actions: " . implode(", ", $actions);
            die($str);
        }

        global $dataLayer;
        // add
        if ($action === $actions[0]) {
            $_SESSION['logged']->getPlaylist()->addSong($song_id);
        }
        // remove
        else if ($action === $actions[1]) {
            $_SESSION['logged']->getPlaylist()->removeSong($song_id);
        }

        $previous = $this->_f3->get('GET.prev');
        if (!empty($previous))
        $this->_f3->reroute($previous);
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
        $email = "";

        //If the form has been posted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

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

            if (!Validator::validEmail($email)) {
                //set an error
                $this->_f3->set('errors["email"]', 'Please enter a valid email');
            }
            //Redirect user to next page if there are no errors
            if (empty($this->_f3->get('errors'))) {
                global $dataLayer;
                $account = new User($email, $username, $password);
                $account->register();
                $this->_f3->reroute('/');
            }
        }

        $this->_f3->set('username', $username);
        $this->_f3->set('password', $password);
        $this->_f3->set('email', $email);


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

    public function dataTablesProcessing()
    {
        global $dataLayer;
        $songs = $dataLayer->getSongs();
        $object = array("data"=>array());
        foreach($songs as $item)
        {
            if (!empty($_SESSION['logged']) && !in_array($item['song']['id'], $_SESSION['logged']->getPlaylist()->getSongIds())) {
                $songToggle = "<a href=\"" . $this->_f3->get('BASE') . "/api/song/add/" . $item['song']['id'] . "?prev=" . $this->_f3->get('PATH') . "\">Add</a>";
            } else {
                $songToggle = "<a href=\"" . $this->_f3->get('BASE') . "/api/song/remove/" . $item['song']['id'] . "?prev=" . $this->_f3->get('PATH') . "\">Remove</a>";
            }
            $temp = array(
                $songToggle,
                $item['song']['title'],
                $item['artist']['name'],
                $item['artist']['terms'],
                "" . number_format($item['song']['duration'] / 60, 2) . " mins",
                $item['song']['year'] == 0 ? "Unknown" : $item['song']['year']
            );
            array_push($object["data"], $temp);
        }
        echo json_encode($object);

    }
}
