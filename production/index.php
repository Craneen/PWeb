<?php

if (session_status() != PHP_SESSION_ACTIVE)
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$_SESSION["dirmaster"] = ($_SERVER['DOCUMENT_ROOT']."/PWeb/production/");
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JobBoard</title>
<link rel="icon" href="dres/panda.png"/>
<link rel="stylesheet" href="style/index-style.css?id=347">
<script src="script/index-script.js"></script>
<script src="script/usrconnect-script.js"></script>
</head>

<body>
<header>
<div id="navigation-menu">
<button onclick="DropDown()" class="dropbtn">Menu</button>
<div id="myDropdown" class="dropdown-content">

</div>
</div>
</header>


<div id="page-container" class="page-container">
<div id="user-menu"></div>
<div id="error-display"></div>
<div id="formular_div" class="hidden"></div>

<?php
if (isset($_GET["pages"]))
{
	$pages = htmlspecialchars($_GET["pages"]);
	$page_content = $_SESSION["IndexCore"]->dynamic_body("pages/".$pages);
	echo $page_content;
}
?>
</div>



</body>

</html>
