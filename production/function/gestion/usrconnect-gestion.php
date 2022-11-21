<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
        if ($_GET["options"] == "signInUser")
        {
            if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['vpassword']))
            {
                echo $_SESSION["UserCore"]->addUser($_POST);
            }
            else
                echo "-1";
        }

        if ($_GET["options"] == "signUpUser")
        {
            if (isset($_POST['email']) && isset($_POST['password']))
            {
                echo $_SESSION["UserCore"]->connectUser($_POST);
            }
            else
                echo "-1";
        }

        if ($_GET["options"] == "getSignInUser")
        {
            echo <<<HTML
            <div id="error-display" class="form_content"></div>
            <form id="sign-in-form" onsubmit="return addSignIn()">

            <label for="first_name" class="form_content"> First name </label>
            <input type="text" name="first_name" id="first_name" class="form_content" required><br>
            <label for="last_name" class="form_content"> Last name </label>
            <input type="text" name="last_name" id="last_name" class="form_content" required><br>


            <label for="email" class="form_content"> Email </label>
            <input type="text" name="email" id="email" class="form_content" required><br>
            <label for="phone" class="form_content"> Phone </label>
            <input type="text" name="phone" id="phone" class="form_content" required><br>
            <label for="password" class="form_content"> Password </label>
            <input type="password" name="password" id="password" class="form_content" required><br>
            <label for="vpassword" class="form_content"> Re-Password </label>
            <input type="password" name="vpassword" id="vpassword" class="form_content" required><br>

            <input type="submit" id='submit' value="Sign In" class="form_content">


            </form>
            HTML;
        }

        if ($_GET["options"] == "getSignUpUser")
        {

            echo <<<HTML
            <form id="sign-up-form" onsubmit="return signUp()">

            <label for="email" class="form_content"> Email </label>
            <input type="text" name="email" id="email" class="form_content" required><br>
            <label for="password" class="form_content"> Password </label>
            <input type="password" name="password" id="password" class="form_content" required><br>
            <input type="submit" id='submit' value="Sign Up" class="form_content">

            </form>
            HTML;

        }

        if($_GET["options"] == "disconnect")
            $_SESSION["UserCore"]->disconnect();

        if($_GET["options"] == "chargeMenu")
        {
            $test = false;
            if (isset($_COOKIE["token"]))
            {
                if ( $_SESSION["UserCore"]->isValidToken($_COOKIE["token"]) )
                    $test = true;
            }


            if($test)
            {
                echo <<<HTML
                <img id="imgform" onclick="ShowForm()" class="panda" src="dres/users.png" height ="40" width="50"/>
                HTML;
            }
            else
            {
                echo <<<HTML
                <img id="imgform" onclick="ShowForm()" class="panda" src="dres/panda.png" height ="40" width="50"/>
                HTML;
            }

            if($test == true)
            {

                $usr = $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"]);
                echo <<<HTML
                <div id="form-connexion" class="form-connect-div form-div ">
                Connected as :
                <br>{$usr['first_name']}
                <br>{$usr['last_name']}
                <br><button class="form_content" onclick="disconnect()">Disconnect</button>
                </div>
                HTML;

            }
            else
            {
                echo <<<HTML
                <div id="form-connexion" class="form-connect-div form-div ">
                <img src="dres/needleleftyellow.png" width=70vw height=70vh class="form_content">
                <div>
                <button class="form_content" onclick="GetSignIn()">Sign In</button>
                <button class="form_content" onclick="GetSignUp()">Sign Up</button>
                </div>
                <div id="form-sign-div" class="form_content">
                </div>
                </div>
                HTML;
            }

        }

        if($_GET["options"] == "chargeMenuDeroulant")
        {
            echo <<<HTML
            <a href="index.php?pages=accueil">Accueil</a>
            <a href="index.php?pages=offres">Offres</a>
            HTML;

            if (isset($_COOKIE['token']))
                if ($_SESSION['UserCore']->isAdmin($_COOKIE['token']))
                    echo "<a href=\"index.php?pages=dashboard\">Dashboard</a>";

            if (isset($_COOKIE['token']))
            {
                if (!$_SESSION['UserCore']->isInCompany($_COOKIE['token']))
                    echo "<a href=\"index.php?pages=create_compagny\">Create a compagny !</a>";
                else
                    echo "<a href=\"index.php?pages=compagny\">See you're compagny !</a>";

            }
        }

    }
}
