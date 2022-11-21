
<?php
    if (isset($_COOKIE["token"]))
        if ($_SESSION["UserCore"]->isAdmin($_COOKIE["token"]))
        {
            $usr = $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"]);
            if (preg_match("{same}", $usr["first_name"])) // la petite regex du fun =)
                echo <<<HTML
        <link rel="stylesheet" href="style/easter_bunny.css?id=347">
        <img id="bunny" src="dres/bigbunny.png">
        <p>This page is an secret one to just place an bunny from LibLapin =)<br>
        This is also an option to place an RegEx because it is fun !<br>
        If you see this page ! you might be an cheater, so maybe congrats !
        </p>
        HTML;
        }
    