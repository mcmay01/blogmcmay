<?php

namespace Security;

class Session
{

    private $signed_in = false;
    public $user_id;
    public $username;
    public $message;
    public $count;
    public $login_string;
    public $user_browser;
    private $login_checker;

    public function __construct()
    {
        $this->sec_start_session();
        $this->check_login();
        $this->check_message();
        $this->visitor_count();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['_token'])) {
                die("invalid action <a href='../'>Home Page</a>");
            }
            if (hash_equals($_SESSION['_token'], $_POST['_token']) === false) {
                die("Invalid action, redirect to home <a href='../'>Home Page</a>");
            }
        }
    }

    //TOKEN CREATE AND REQUIRE METHODS.
    public function create_token_onget($data = '')
    {
        if (empty($data)) die("Token empty!");
        list($tokenName, $tokenData) = explode("_", $data);
        $tokenGeneric = TOKEN_KEY . $_SERVER['SERVER_NAME'] . $tokenName;
        $token = hash('sha256', $tokenGeneric . $tokenData);
        return array('token' => $token, 'userData' => $data);
    }

    public function token_data(){
        if (isset($_SESSION['token_onget'])) return $_SESSION['token_onget'];
    }

    public function check_token_onget($tokenReceived = '', $dataReceived = '')
    {
        if (empty($tokenReceived) || empty($dataReceived)) die("Token empty!");
        list($tokenName, $data) = explode("_", $dataReceived);
        $tokenGeneric = TOKEN_KEY . $_SERVER['SERVER_NAME'] . $tokenName;
        $token = hash('sha256', $tokenGeneric . $data);
        if ($tokenReceived !== $token)
            die("Invalid signature! <a href='index.php'>Home</a>");
//        list($tokenDate, $userData) = explode("_", $dataReceived);
//        return $this->create_token_onget(time()."#".$userData);
    }

    public function add_token()
    {
        global $tokenRegistered;
        if (empty($tokenRegistered))
            $tokenRegistered = $this->create_token_onget($_SESSION['token_onget']);
        return "&token={$tokenRegistered['token']}&data={$tokenRegistered['userData']}";
    }

    public function sec_start_session()
    {
        $session_name = "gengadug_user_session";
        $path = "/";
        $secure = SECURE;
        // Js access session id not.
        $httponly = true;
        $lifetime = time() + (3600 * 2);
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ./error.php?err=(ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($lifetime, $path, $cookieParams["domain"], $secure, $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();
        session_regenerate_id();

        if (empty($_SESSION['_token'])) {
            if (function_exists('mcrypt_create_iv')) {
                $_SESSION['_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
            } else {
                $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(32));
            }
        }
        if (empty($_SESSION['token_onget'])) {
            $_SESSION['token_onget'] = "CToken_" . time() / 2;;
        }
    }
    public function create_instant_msg($the_msg){
        if (!empty($the_msg)){
            $the_msg = strip_tags($the_msg);
            $the_msg = htmlentities($the_msg);
            $_SESSION['the_msg'] = $the_msg;
        }
    }
    public function return_instant_mgs(){
        if ($this->check_instant_msg()) return $_SESSION['the_msg'];
    }
    public function check_instant_msg(){
        if (isset($_SESSION['the_msg'])) return true;
    }

    public function visitor_count()
    {
        if (isset($_SESSION['count'])) {
            return $this->count = $_SESSION['count']++;
        } else {
            return $_SESSION['count'] = 1;
        }
    }

    public function message($msg = "")
    {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    private function check_message()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    public function is_signed_in()
    {
        return $this->login_checking();
    }

    public function login($user)
    {
        if ($user) {
            $this->signed_in = true;
            return $this->user_id = $_SESSION['id'] = $user->id;
        }
    }

    public function login_checking()
    {
        if ($this->signed_in == true) {
            if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
                $this->user_id = $_SESSION['user_id'];
                $this->username = $_SESSION['username'];
                $this->login_string = $_SESSION['login_string'];
                $this->user_browser = $_SERVER['HTTP_USER_AGENT'];

                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                if ($stmt = $conn->prepare("SELECT password FROM gengadug_login WHERE id = ? LIMIT 1")) {
                    $stmt->bind_param('i', $this->user_id);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($password);
                        $stmt->fetch();
                        $this->login_checker = hash('sha512', $password . $this->user_browser);
                        if ($this->login_checker == $this->login_string) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    public function redirect($r_location, $time = '')
    {
        header("Location: {$r_location}");
    }

    //logout method
    public function logout()
    {
        // Unset all session values
        $_SESSION = array();
        // get session parameters
        $params = session_get_cookie_params();
        // Delete the actual cookie.
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        // Destroy session
        session_destroy();
        unset($this->user_id);
        unset($_SESSION['username']);
        unset($_SESSION['login_string']);
        $this->signed_in = false;

    }

    private function check_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;

        }
    }
    public function msg_redirect_exit($instant='', $redirect=''){
        global $url;
        if (!empty($instant)) $this->create_instant_msg($instant);
        if (!empty($redirect)) {$this->redirect($redirect);} else {$this->redirect($url);}
        exit();
    }
}
