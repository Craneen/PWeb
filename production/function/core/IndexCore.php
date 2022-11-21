<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";


class IndexCore
{

    function dynamic_body($page)
    {
        if (file_exists($page.".php"))
        {
            ob_start();
            include ($page.".php");
            return ob_get_clean();
        }
        return <<<HTML
        <div>
        Erreur 404<br>
        <img src="dres/panda.png">
        </div>
        HTML;
    }

    function go($loc)
    {
        header("Location: $loc");
        exit();
    }

    function encrypt_password($name, $pswd)
    {
        $pswd = $pswd.$GLOBALS['EXT'].$name;
        $pswd = hash_hmac("sha256", $pswd, $GLOBALS['KEY']);
        $pswd = hash_hmac("whirlpool", $pswd, $GLOBALS['KEY']);
        $pswd = hash_hmac("sha1", $pswd, $GLOBALS['KEY']);
        return $pswd;
    }

    function require_all()
    {
        $dbg = false;
        require_once($_SESSION["dirmaster"]."function/core/DatabaseCore.php");
        ($dbg) ? $_SESSION["DatabaseCore"]->test_run() : "";
        require_once($_SESSION["dirmaster"]."function/core/UserCore.php");
        ($dbg) ? $_SESSION["UserCore"]->test_run() : "";
        require_once($_SESSION["dirmaster"]."function/core/CompanyCore.php");
        ($dbg) ? $_SESSION["CompanyCore"]->test_run() : "";
    }

    function validatePhone($phone){
        return (preg_match("/^[0-9]{10}+$/", $phone)) ? true : false;
    }

    function validateEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    function __construct()
    {
        $this->require_all();
    }


}



$_SESSION["IndexCore"] = new IndexCore();
