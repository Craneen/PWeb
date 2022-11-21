<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
    }
}
