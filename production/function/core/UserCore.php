<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");

class UserCore
{

    function isValidToken ($token)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("user", " `token`=\"".$token."\"");
        $result = $result_request->fetch();
        if (isset($result["token"]))
            if ($result["token"] == $token)
                return true;
        return false;
    }

    function mailExist($mail)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("user", " `email`=\"".$mail."\"");
        $result = $result_request->fetch();
        if (isset($result["email"]))
            if ($result["email"] == $mail)
                return true;
        return false;
    }

    function getUserByToken($token)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("user", " `token`=\"".$token."\"");
        $result = $result_request->fetch();
        if (isset($result["token"]))
            return $result;
        return NULL;
    }

    function getUser($mail)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("user", " `email`=\"".$mail."\"");
        $result = $result_request->fetch();
        if (isset($result["email"]))
            return $result;
        return NULL;
    }

    function connectUser($post_data)
    {
        if (($usr = $this->getUser($post_data['email'])) != NULL)
        {
            $psw = $_SESSION["IndexCore"]->encrypt_password($post_data['email'], $post_data['password']);
            if ($post_data['email'] == $usr['email'] &&
                $psw == $usr['password'])
            {
                if (!isset($_COOKIE['token']))
                setcookie("token", $usr["token"], time() + (86400 * 30), "/"); // Création d'un cookie de connection [token]
            }
            else
                return -88;
        }
        else
            return -89;
    }

    function addUser($post_data)
    {
        if ($_SESSION["IndexCore"]->validateEmail($post_data['email']) == false)
            return -87;
        if ($this->mailExist($post_data['email']) == true)
            return -89;
        if ($post_data['password'] == $post_data['vpassword'])
        {
            $data = array (
                "first_name" => $post_data["first_name"],
                "last_name" => $post_data["last_name"],
                "email" => $post_data["email"],
                "phone" => $post_data["phone"],
                "password" => $_SESSION["IndexCore"]->encrypt_password($post_data['email'], $post_data['password']),
                "token" => $_SESSION["IndexCore"]->encrypt_password($post_data['first_name'].$post_data['last_name'], $post_data['password'].$post_data['first_name'].$post_data['last_name'].$post_data['email'])
            );
            $res = $_SESSION["DatabaseCore"]->insert_fields("user", $data);
            if ($res != -1)
            {
                if (!isset($_COOKIE['token']))
                setcookie("token", $data["token"], time() + (86400 * 30), "/"); // Création d'un cookie de connection [token]
                return $res;
            }
            else
                return -1;
        }
        return -88;
    }


    function disconnect()
    {
        setcookie("token", "", time() - 3600, "/"); // Destruction du cookies de connection [token]
    }

    function isAdmin($token){
        return ($this->getUserByToken($token)['grade'] == 7) ? true : false;
    }

    function isInCompany($token){
        return ($_SESSION["CompanyCore"]->is_not_member($this->getUserByToken($token)['id'])) ? false : true;
    }

    function test_run()
    {
        echo "The UserCore is Ok !<br>";
    }

}

$_SESSION["UserCore"] = new UserCore();
