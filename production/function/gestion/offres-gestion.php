<?php

if (session_status() != PHP_SESSION_ACTIVE)
session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
        if ($_GET["options"] == "addAdv")
        $_SESSION["DatabaseCore"]->insert_fields("advertisements", $_POST);
        
        
        if ($_GET["options"] == "getAdv")
        {
            if (isset($_COOKIE['token']))
            if ($_SESSION['UserCore']->isInCompany($_COOKIE['token']))
            echo <<<HTML
            <div class="note-div">
            <div class="note-div-t" style="background:linear-gradient(0deg, rgba(255,0,234,0) 90%, blue 100%);">
            <img src="dres/needleleftyellow.png" width=70vw height=70vh>
            <form id="advertissements-form" onsubmit="return addAdvertissements()">
            <div>
            <label for="name"> Name </label>
            <input type="text" name="name" id="name" required>
            </div>
            <div>
            <label for="description"> Description </label>
            <input type="text" name="description" id="description" required>
            </div>
            <div>
            <label for="place"> Place </label>
            <input type="text" name="place" id="place">
            </div>
            <div>
            <label for="start"> Start </label>
            <input type="date" id="start" name="start">
            </div>
            <div>
            <label for="contract_type"> Contract type </label>
            <input type="text" id="contract_type" name="contract_type" >
            </div>
            <div>
            <label for="wages"> Wage </label>
            <input type="text" id="wages" name="wages" >
            </div>
            <div>
            <label for="color"> Color </label>
            <input type="color" id="color" name="color" >
            </div>
            <input type="hidden" id="company_id" name="company_id" value='{$_SESSION["CompanyCore"]->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"])}'>
            <div>
            <input type="submit" value="Submit">
            </div>
            </form>
            </div>
            </div>
            HTML;
            
            $advertissements = $_SESSION["DatabaseCore"]->select_fields("advertisements", "1");
            if (isset($advertissements))
            {
                $nb_items = 0;
                while (($value = $advertissements->fetch()) != NULL)
                {
                    if ($value["applicate"] == -1)
                    {
                        echo <<<HTML
                        <div class="note-div" id="needle_{$nb_items}">
                        <div id="needle_{$nb_items}_under" class="note-div-t" style="background:linear-gradient(0deg, rgba(255,0,234,0) 90%, {$value['color']} 100%);"> 
                        <img src="dres/needleleftred.png" class="needle" width=70vw height=70vh>
                        HTML;
                        if ($value["company_id"] != -1)
                        echo <<<HTML
                        <h2>{$_SESSION["CompanyCore"]->getCompany($value["company_id"])["name"]}</h2>
                        HTML;
                        echo <<<HTML
                        <h3> {$value["name"]} </h3><br>
                        <p class="ellipsis"> {$value["description"]} </p><br>
                        <p> {$value["wages"]} </p><br>
                        <p> {$value["place"]} </p><br>
                        <div class="tooltip">
                        <img src="dres/scale_icon.png" onclick="seeMore('needle_{$nb_items}')" width=70vw height=70vh>
                        <span class="tooltiptext">Scale up/down</span>
                        </div>
                        HTML;
                        if ($_SESSION["CompanyCore"]->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"]) != $value["company_id"] && $_SESSION["CompanyCore"]->have_candidate($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"], $value['id']))
                        {
                            echo <<<HTML
                            <div class="tooltip">
                            <img src="dres/postuler.png" onclick="postuler('$nb_items', {$value['id']})" width=70vw height=70vh>
                            <span class="tooltiptext">Postuler</span>
                            </div>
                            HTML;
                        }
                        echo <<<HTML
                        </div>
                        </div>
                        HTML;                        
                    }
                    $nb_items++;
                }
                
                
                if ($nb_items == 0)
                {
                    echo <<<HTML
                    <h2>Aucune offre n'est disponible !</h2>
                    HTML;
                }
            }
            else
            echo "La requête SQL a échoué";
            
        }
        
        
        
        if ($_GET["options"] == "showFormularCandidate")
        {
            
            $nb_items = $_POST["number"];
            $off_id = $_POST["offre"];

            $advertissement = $_SESSION["DatabaseCore"]->select_fields("advertisements", "`id`=".$off_id)->fetch();            
            
            echo <<<HTML
            <div class="form-candidature" id="form_{$nb_items}">
            <img src="dres/needleleftyellow.png" width=70vw height=70vh>
            <h3> {$advertissement["name"]} </h3><br>
            <p class="ellipsis"> {$advertissement["description"]} </p><br>
            <p> {$advertissement["wages"]} </p><br>
            <p> {$advertissement["place"]} </p><br>

            <form id="cand_form_{$nb_items}" onsubmit="return addCandidature('cand_form_{$nb_items}')">
            HTML;
            echo <<<HTML
            <label for="first_name"> First name </label>
            HTML;
            echo '<input type="text" name="first_name" value="'.((isset($_COOKIE["token"])) ? (isset($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["first_name"]) ? $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["first_name"] : "") : "").'" required><br>';
            
            echo <<<HTML
            <label for="last_name"> Last name </label>
            HTML;
            echo '<input type="text" name="last_name" value="'.((isset($_COOKIE["token"])) ? (isset($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["last_name"]) ? $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["last_name"] : "") : "").'" required><br>';
            
            echo <<<HTML
            <label for="email"> Email </label>
            HTML;
            echo '<input type="text" name="email" value="'.((isset($_COOKIE["token"])) ? (isset($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["email"]) ? $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["email"] : "") : "").'" required><br>';
            
            echo <<<HTML
            <label for="phone"> Phone </label>
            HTML;
            echo '<input type="text" name="phone" value="'.((isset($_COOKIE["token"])) ? (isset($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["phone"]) ? $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["phone"] : "") : "").'" required><br>';
            
            echo '<input type="hidden" name="id_advertissement" value="'.$off_id.'" required>';
            echo '<input type="hidden" name="id_user" value="'.((isset($_COOKIE["token"])) ? (isset($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"]) ? $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"] : "-89") : "-89").'" required>';
            
            echo <<<HTML
            <br>
            <input type="submit" value="Submit">
            <button onclick="clear_tutut()">Return</button>
            </div>
            </form>
            </div>
            HTML;
            
            
        }
        
    }
}
