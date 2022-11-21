<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
        if ($_GET["options"] == "getCompagnyCreationForm")
        {

            if (isset($_COOKIE['token']))
            {
                if (!$_SESSION['UserCore']->isInCompany($_COOKIE['token']))
                {
                    echo <<<HTML

                    <form id="compagny-form" onsubmit="return addCompagny()">
                    <label for="name"> Name </label>
                    <input type="text" name="name" id="name" required><br>
                    <label for="phone"> Phone </label>
                    <input type="text" name="phone" id="phone" required><br>
                    <label for="email"> Email </label>
                    <input type="text" name="email" id="email" required><br>
                    <label for="adresse"> Adresse </label>
                    <input type="text" name="adresse" id="adresse" required><br>
                    <input type="submit" value="Submit">
                    </form>


                    HTML;
                }
                else
                    echo <<<HTML
                <div>
                Erreur 404<br>
                <img src="dres/panda.png">
                </div>
                HTML;

            }
            else
                echo <<<HTML
            <div>
            Erreur 404<br>
            <img src="dres/panda.png">
            </div>
            HTML;

        }
        if ($_GET["options"] == "addCompagny")
        {
            echo $_SESSION["CompanyCore"]->addCompagny($_POST);
        }

    }
}
