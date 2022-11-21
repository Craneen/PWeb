<?php

if (session_status() != PHP_SESSION_ACTIVE)
session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
        
        if ($_GET["options"] == "getAdvertisement")
        {
            $advList = $_SESSION["DatabaseCore"]->select_fields("advertisements", "1");
            while (($adv = $advList->fetch()) != NULL)
            {
                
                echo <<<HTML
                <div class="offres-div-dashboard">
                <div class="div_tq">
                <img src="dres/needleleftred.png" width=70vw height=70vh>
                HTML;
                if ($adv["company_id"] != -1)
                echo <<<HTML
                <h3>{$_SESSION["CompanyCore"]->getCompany($adv["company_id"])["name"]}</h3>
                HTML;
                echo <<<HTML
                <h4>{$adv["name"]}</h4>
                <p>{$adv["id"]}|{$adv["description"]}|{$adv["wages"]}|{$adv["place"]}|{$adv["start"]}|{$adv["contract_type"]}|{$adv["color"]}</p>
                </div>
                <div class="div_uq">
                <button onclick="modify_form('advertisements', {$adv['id']})">M</button><br>
                <button onclick="delete_offres({$adv['id']})">X</button>
                </div>
                </div>
                HTML;
            }
        }
        
        if ($_GET["options"] == "getCompanies")
        {
            $cpnList = $_SESSION["DatabaseCore"]->select_fields("companies", "1");
            while (($cpn = $cpnList->fetch()) != NULL)
            {
                echo <<<HTML
                <div class="companies-div-dashboard">
                <div class="div_tq">
                <img src="dres/needleleftred.png" width=70vw height=70vh>
                <h4>{$cpn["name"]}</h4>
                <p>{$cpn["id"]}|{$cpn["phone"]}|{$cpn["email"]}|{$cpn["adresse"]}</p>
                </div>
                <div class="div_uq">
                <button onclick="modify_form('company', {$cpn['id']})">M</button><br>
                <button onclick="delete_company({$cpn['id']})">X</button>
                </div>
                
                </div>
                HTML;
            }
        }
        
        
        if ($_GET["options"] == "getUser")
        {
            $usrList = $_SESSION["DatabaseCore"]->select_fields("user", "1");
            while (($usr = $usrList->fetch()) != NULL)
            {
                echo <<<HTML
                <div class="user-div-dashboard">
                <div class="div_tq">
                <img src="dres/needleleftred.png" width=70vw height=70vh>
                <h4>{$usr["first_name"]} {$usr["last_name"]}</h4>
                <p>{$usr["id"]} | {$usr["grade"]} | {$usr["email"]} | {$usr["token"]}</p>
                </div>
                <div class="div_uq">
                <button onclick="modify_form('user', {$usr['id']})">M</button><br>
                HTML;
                
                if (!$_SESSION["UserCore"]->isAdmin($usr["token"]))
                echo "<button onclick=\"delete_user({$usr['id']})\">X</button>";
                
                echo <<<HTML
                </div>
                </div>
                HTML;
            }
        }
        
        if ($_GET["options"] == "delAdv")
        $_SESSION["DatabaseCore"]->delete_fields("advertisements", "`id`=".$_POST["id"]);
        if ($_GET["options"] == "delCpn")
        $_SESSION["DatabaseCore"]->delete_fields("companies", "`id`=".$_POST["id"]);
        if ($_GET["options"] == "delUsr")
        $_SESSION["DatabaseCore"]->delete_fields("user", "`id`=".$_POST["id"]);
        
        
        if ($_GET['options'] == "getUserF")
        {
            echo <<<HTML
            Form to add User
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
        
        if ($_GET['options'] == "getAdvertisementF")
        {
            echo <<<HTML
            Form to add advertisements
            <form id="advertisements-form" onsubmit="return addAdvertisements()">
            <label for="name"> Name </label>
            <input type="text" name="name" id="name" required> <br>
            <label for="description"> Description </label>
            <input type="text" name="description" id="description" required> <br>
            <label for="place"> Place </label>
            <input type="text" name="place" id="place"> <br>
            <label for="start"> Start </label>
            <input type="date" id="start" name="start"> <br>
            <label for="contract_type"> Contract type </label>
            <input type="text" id="contract_type" name="contract_type" > <br>
            <label for="wages"> Wage </label>
            <input type="text" id="wages" name="wages" > <br>
            <label for="color"> Color </label>
            <input type="color" id="color" name="color" > <br>
            <input type="hidden" id="company_id" name="company_id" value='{$_SESSION["CompanyCore"]->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])["id"])}'>
            <input type="submit" value="Submit">
            </form>
            HTML;
        }
        
        if ($_GET['options'] == "getCompaniesF")
        {
            echo <<<HTML
            Form to add Company
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
        
        
        if ($_GET["options"] == "mod_company")
        {
            echo $_POST["id"];
            $companies = $_SESSION["DatabaseCore"]->select_fields("companies", "`id`=".$_POST["id"])->fetch();
            echo <<<HTML
            
            <form id="mod_company-form" onsubmit="return mod_db('company')">
            Form to Modify Company<br>
            <label for="name"> Name </label>
            <input type="text" name="name" id="name" value="{$companies['name']}" required><br>
            <label for="phone"> Phone </label>
            <input type="text" name="phone" id="phone" value="{$companies['phone']}" required><br>
            <label for="email"> Email </label>
            <input type="text" name="email" id="email" value="{$companies['email']}" required><br>
            <label for="adresse"> Adresse </label>
            <input type="text" name="adresse" id="adresse" value="{$companies['adresse']}" required><br>
            <input type="hidden" id="id" name="id" value="{$companies['id']}">
            <input type="submit" value="Submit"><br>
            <button onclick="clear_tutut()">Return</button>
            </form>
            
            HTML;
        }
        if ($_GET["options"] == "mod_user")
        {
            $user = $_SESSION["DatabaseCore"]->select_fields("user", "`id`=".$_POST["id"])->fetch();
            echo <<<HTML
            <form id="mod_user-form" onsubmit="return mod_db('user')">
            Form to add User<br>
            <label for="first_name" class="form_content"> First name </label>
            <input type="text" name="first_name" id="first_name" class="form_content" value="{$user['first_name']}" required><br>
            <label for="last_name" class="form_content"> Last name </label>
            <input type="text" name="last_name" id="last_name" class="form_content" value="{$user['last_name']}" required><br>
            <label for="email" class="form_content"> Email </label>
            <input type="text" name="email" id="email" class="form_content" value="{$user['email']}" required><br>
            <label for="phone" class="form_content"> Phone </label>
            <input type="text" name="phone" id="phone" class="form_content" value="{$user['phone']}" required><br>
            <label for="grade" class="form_content"> grade </label>
            <select name="grade" id="grade" class="form_content" required>
            HTML;
            echo ($user['grade'] == 0) ? "<option value='0' selected>Membre</option>" : "<option value='0'>Membre</option>";            
            echo ($user['grade'] == 7) ? "<option value='7' selected>Administrateur</option>" : "<option value='7'>Administrateur</option>";
            
            echo <<<HTML
            </select>
            <input type="hidden" id="id" name="id" value="{$user['id']}">
            <input type="submit" id='submit' value="Sign In" class="form_content"><br>
            <button onclick="clear_tutut()">Return</button>
            </form>
            HTML;
        }
        if ($_GET["options"] == "mod_advertisements")
        {
            $advertisements = $_SESSION["DatabaseCore"]->select_fields("advertisements", "`id`=".$_POST["id"])->fetch();
            $datt = date('Y-m-d', strtotime($advertisements['start']));
            echo <<<HTML
            <form id="mod_advertisements-form" onsubmit="return mod_db('advertisements')">
            Form to add advertisements<br>
            <label for="name"> Name </label>
            <input type="text" name="name" id="name" value="{$advertisements['name']}" required> <br>
            <label for="description"> Description </label>
            <input type="text" name="description" id="description" value="{$advertisements['description']}" required> <br>
            <label for="place"> Place </label>
            <input type="text" name="place" id="place" value="{$advertisements['place']}" > <br>
            <label for="start"> Start </label>
            <input type="date" id="start" name="start" value="{$datt}" > <br> 
            <label for="contract_type"> Contract type </label>
            <input type="text" id="contract_type" name="contract_type" value="{$advertisements['contract_type']}" > <br>
            <label for="wages"> Wage </label>
            <input type="text" id="wages" name="wages" value="{$advertisements['wages']}" > <br>
            <label for="color"> Color </label>
            <input type="color" id="color" name="color" value="{$advertisements['color']}" > <br>
            <input type="hidden" id="id" name="id" value="{$advertisements['id']}">
            <input type="hidden" id="company_id" name="company_id" value="{$advertisements['company_id']}">
            <input type="submit" value="Submit"><br>
            <button onclick="clear_tutut()">Return</button>
            </form>
            HTML;
            
            
        }
        
        
        if ($_GET['options'] == 'mod_db_user')
        {
            $id = $_POST["id"];
            unset($_POST['id']);
            $_SESSION["DatabaseCore"]->update_fields("user", $_POST, "`id`=$id");
        }
        if ($_GET['options'] == 'mod_db_company')
        {
            $id = $_POST["id"];
            unset($_POST['id']);
            $_SESSION["DatabaseCore"]->update_fields("companies", $_POST, "`id`=$id");
        }
        if ($_GET['options'] == 'mod_db_advertisements')
        {
            print_r($_POST);
            $id = $_POST["id"];
            unset($_POST['id']);
            $_SESSION["DatabaseCore"]->update_fields("advertisements", $_POST, "`id`=$id");
        }
        
    }
}
