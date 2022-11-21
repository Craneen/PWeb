<?php

if (session_status() != PHP_SESSION_ACTIVE)
session_start();
$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");


if (isset($_POST) && isset($_GET))
{
    if (isset($_GET['options']))
    {
        if ($_GET['options'] == "addCandidature")
        $_SESSION["DatabaseCore"]->insert_fields("advertisements_candidature", $_POST);
        
        if ($_GET['options'] == "addMember")
        {
            $_POST["id_user"] = $_SESSION["UserCore"]->getUser($_POST["email"])['id'];
            unset($_POST['email']);
            if ($_SESSION['CompanyCore']->is_not_member($_POST['id_user']))
            $_SESSION['CompanyCore']->addMemberCompagny($_POST['id_companies'], $_POST['id_user']);
        }
        
        if ($_GET["options"] == "changeGrade")
        $_SESSION["DatabaseCore"]->update_fields('companies_member', $_POST, "`id_companies`=".$_POST["id_companies"]." AND `id_user`=".$_POST["id_user"]);
        
        if ($_GET["options"] == "delMember")
        $_SESSION["DatabaseCore"]->delete_fields('companies_member', "`id_companies`=".$_POST["id_companies"]." AND `id_user`=".$_POST["id_user"]);
        
        
        if ($_GET["options"] == "chargePage")
        {
            $comp_id = $_SESSION['CompanyCore']->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id']);
            $usr = $_SESSION['CompanyCore']->get_member_user($comp_id, $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id'])->fetch();
            echo <<<HTML
            <img src="dres/needleleftred.png" width=70vw height=70vh>
            <h3>Member List</h3>
            HTML;
            if ($usr['grade'] == 7 ||
            $usr['grade'] == 6)
            echo <<<HTML
            <div>
            <h5>Add Member to Company</h5>
            <form id="add_member_company_form" onsubmit="return addMemberComp()">
            <input type="hidden" name="id_companies" value="{$comp_id}" required>
            <label for="email"> Email </label>
            <input type="text" id="email" name="email" required><br>
            <input type="submit" value="submit">
            </form>
            </div>
            HTML;
            echo <<<HTML
            <table>
            HTML;
            $list_members = $_SESSION["CompanyCore"]->get_member($comp_id);
            //while to print user list
            while (($member = $list_members->fetch()) != NULL)
            {
                echo "<tr><th>First_name : {$member['first_name']} | Last name : {$member['last_name']} | Email : {$member['email']} | ";
                if ($usr['grade'] == 7 || $usr['grade'] == 6)
                if ($member['grade'] < 6)
                echo <<<HTML
                <button onclick="return remove_user_compagnie('{$member['id_user']}', '{$member['id_companies']}')">X</button>
                |
                HTML;
                if ($usr['grade'] == 7 ||
                $usr['grade'] == 6)
                {
                    if (($usr['grade'] == 6 || $usr['grade'] == 7) && $member['grade'] == 7)
                    echo "Administrateur";
                    else if ($usr['grade'] == 6 && $member['grade'] == 6)
                    echo "Responsable";
                    else
                    {
                        echo <<<HTML
                        <select onChange="return changeRole(this.value, {$member['id_user']}, {$comp_id});">;
                        HTML;
                        if ($usr['grade'] == 7 && $member['grade'] == 7)
                        echo ($member["grade"] == 7) ? "<option value='7' selected>Administrateur</option>" : "<option value='7'>Administrateur</option>";
                        if ($usr['grade'] == 7)
                        echo ($member["grade"] == 6) ? "<option value='6' selected>Responsable</option>" : "<option value='6'>Responsable</option>";
                        echo ($member["grade"] == 0) ? "<option value='0' selected>Membre</option>" : "<option value='0'>Membre</option>";
                        echo ($member["grade"] == 1) ? "<option value='1' selected>Stagiaires</option>" : "<option value='1'>Stagiaires</option>";
                        echo "</select></th></tr>";
                    }
                }
                else if ($member['grade'] == 7)
                echo "Administrateur";
                else if ($member['grade'] == 6)
                echo "Responsable";
                else if ($member['grade'] == 1)
                echo "Stagiaires";
                else if ($member['grade'] == 0)
                echo "Membre";
            }
            echo <<<HTML
            </table>
            HTML;
            
        }
        
        if ($_GET["options"] == "companyChargeDesc")
        {
            $comp_id = $_SESSION['CompanyCore']->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id']);
            $companie = $_SESSION["DatabaseCore"]->select_fields("companies", "`id` = ".$comp_id)->fetch();
            echo <<<HTML
            <img src="dres/needleleftred.png" width=70vw height=70vh>
            <h3>{$companie["name"]}</h3>
            <p>
            Mail : {$companie["email"]}<br>
            Phone : {$companie["phone"]}<br>
            Adresse : {$companie["adresse"]}<br>
            </p>
            HTML;
        }
        
        if ($_GET['options'] == "changeApplicate")
        {
            print_r($_POST);
            if ($_POST["applicate"] == "1")
            $_SESSION["CompanyCore"]->refuseOther($_POST["id"]);
            $_SESSION["DatabaseCore"]->update_fields('advertisements_candidature', $_POST, "`id`=".$_POST["id"]);
        }
        
        if ($_GET["options"] == "chargeAdvertissements")
        {
            
            $comp_id = $_SESSION['CompanyCore']->is_member($_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id']);
            $companie = $_SESSION["DatabaseCore"]->select_fields("companies", "`id` = ".$comp_id)->fetch();
            $usr = $_SESSION['CompanyCore']->get_member_user($comp_id,
            $_SESSION["UserCore"]->getUserByToken($_COOKIE["token"])['id']
            )->fetch();
            
            $adv_list = $_SESSION["CompanyCore"]->getAdvertisements($comp_id);
            
            echo <<<HTML
            <img src="dres/needleleftred.png" width=70vw height=70vh>
            <h3>Liste des offres publiés [avec les liste d'attente]</h3>
            <table>
            <thead>
            <tr>
            <th> name </th>
            <th> description </th>
            <th> wages </th>
            <th> place </th>
            <th> start </th>
            <th> contract_type </th>
            <th> Modify </th>
            </tr>
            </thead>
            HTML;
            
            while (($adv = $adv_list->fetch()) != NULL)
            {
                echo <<<HTML
                <tr>
                <th>{$adv["name"]} </th>
                <th> {$adv["description"]} </th>
                <th> {$adv["wages"]} </th>
                <th> {$adv["place"]} </th>
                <th> {$adv["start"]} </th>
                <th> {$adv["contract_type"]} </th>
                <th> <button onclick="modify_form('advertisements', {$adv['id']})">Modify</button> </th>
                HTML;
                
                $nb_cand = 0;
                $adv_candidate = $_SESSION["CompanyCore"]->getCandidate($adv["id"]);
                while (($cand = $adv_candidate->fetch()) != NULL)
                {
                    echo <<<HTML
                    </tr>
                    <tr> <td colspan=7>
                    {$cand["first_name"]} | {$cand["last_name"]} | {$cand["email"]} | {$cand["phone"]} |
                    HTML;
                    
                    if ($cand["applicate"] == 0)
                    echo "REFUSER";
                    else if ($cand["applicate"] == 1)
                    echo "ACCEPTER";
                    else if ($cand["applicate"] == -1)
                    {
                        echo <<<HTML
                        <select onChange="return changeApplicate(this.value, {$cand['id']});">
                        <option value='1' selected>Accepter</option>
                        <option value='0' selected>Refuser</option>
                        <option value='-1' selected>En attente</option>
                        </select>
                        HTML;
                    }
                    
                    echo <<<HTML
                    </td><tr>
                    HTML;
                    $nb_cand++;
                }
                
                if ($nb_cand == 0)
                echo <<<HTML
                </tr>
                <tr> <td colspan=7>
                Aucun Candidat !
                </td><tr>
                HTML;
            }
            
            
            echo "</table>";
        }
        
        
    }
}
