<?php
$verif = true;
if (isset($_COOKIE["token"]))
{
    if (!$_SESSION['CompanyCore']->is_not_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id']))
        $verif = false;
}
if ($verif)
    $_SESSION["IndexCore"]->go("index.php?pages=404");

if (!$verif)
{
    echo <<<HTML
    <div class='container'>
    <div id="company_info_div">
    </div>

    <div id="member_list_div">
    </div>

    <div id="advertissement_list_div">
    </div>
    </div>

HTML;





}

?>
    <script src="script/company-script.js">getAdvertissements();</script>
    <link rel="stylesheet" href="style/compagny-style.css?id=347">