<?php

class CompanyCore
{

    function getCompany($id)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("companies", " `id`=\"".$id."\"");
        $result = $result_request->fetch();
        if (isset($result["id"]))
            return $result;
        return NULL;
    }

    function mailExist($mail)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("companies", " `email`=\"".$mail."\"");
        $result = $result_request->fetch();
        if (isset($result["email"]))
            if ($result["email"] == $mail)
                return true;
        return false;
    }

    function is_member($user_id)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("companies_member", " `id_user`=\"".$user_id."\"");
        $result = $result_request->fetch();
        if (isset($result["id_user"]))
            if ($result["id_user"] == $user_id)
                return $result["id_companies"];
        return -1;
    }

    function is_not_member($user_id)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("companies_member", " `id_user`=\"".$user_id."\"");
        $result = $result_request->fetch();
        if (isset($result["id_user"]))
            if ($result["id_user"] == $user_id)
                return false;
        return true;
    }

    function addMemberCompagny($comp_id, $user_id, $grade = 0)
    {
        if ($this->is_not_member($user_id))
        {
            $data = array (
                "id_companies" => $comp_id,
                "id_user" => $user_id,
                "grade" => $grade
            );
            return  $_SESSION["DatabaseCore"]->insert_fields("companies_member", $data);
        }
        return -86;
    }

    function addCompagny($post_data)
    {
        if ($_SESSION["IndexCore"]->validateEmail($post_data['email']) == false)
            return -87;
        if ($_SESSION["IndexCore"]->validatePhone($post_data['phone']) == false)
            return -89;

        if (!$this->mailExist($post_data['email']))
        {
            $data = array (
                "name" => $post_data["name"],
                "phone" => $post_data["phone"],
                "email" => $post_data["email"],
                "adresse" => $post_data["adresse"]
            );
            $res = $_SESSION["DatabaseCore"]->insert_fields("companies", $data);
            if ($res != -1)
            {
                $this->addMemberCompagny($res, $_SESSION["UserCore"]->getUserByToken($_COOKIE['token'])['id'], 7);
                return $res;
            }
            else
                return -1;

        }
        return -86;
    }

    function have_candidate($user_id, $post_id)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("advertisements_candidature", " `id_user`=\"".$user_id."\" AND `id_advertissement`=\"".$post_id."\"");
        $result = $result_request->fetch();
        if (isset($result["id_user"]))
            if ($result["id_user"] == $user_id)
                return false;
        return true;
    }

    function get_member_user($compagny_id, $user_id)
    {
        $sql = "SELECT `user`.*, `companies_member`.* FROM `user`
        INNER JOIN `companies_member` ON `user`.`id` = `companies_member`.`id_user`
        INNER JOIN `companies` ON `companies_member`.`id_companies` = `companies`.`id`
        WHERE `companies`.`id` = ".$compagny_id." AND `id_user`=".$user_id;
        $_SESSION["DatabaseCore"]->exec($sql);
        return $_SESSION["DatabaseCore"]->stmt;
    }

    function get_member($compagny_id)
    {
        $sql = "SELECT `user`.*, `companies_member`.* FROM `user`
        INNER JOIN `companies_member` ON `user`.`id` = `companies_member`.`id_user`
        INNER JOIN `companies` ON `companies_member`.`id_companies` = `companies`.`id`
        WHERE `companies`.`id` = ".$compagny_id;
        $_SESSION["DatabaseCore"]->exec($sql);
        return $_SESSION["DatabaseCore"]->stmt;

    }

    function getAdvertisements($comp_id)
    {
        $result_request = $_SESSION["DatabaseCore"]->select_fields("advertisements", " `company_id`=\"".$comp_id."\"");
        return $result_request;
    }

    function getCandidate($adv_id)
    {
        $sql = "SELECT `advertisements_candidature`.* FROM `advertisements_candidature` WHERE `id_advertissement`=$adv_id";
        $_SESSION["DatabaseCore"]->exec($sql);
        return $_SESSION["DatabaseCore"]->stmt;
    }


    function refuseOther($id_cand)
    {
        $np = array("applicate" => 0);
        $cand = $_SESSION["DatabaseCore"]->select_fields('advertisements_candidature', '`id`='.$id_cand)->fetch();
        $_SESSION["DatabaseCore"]->update_fields('advertisements', $np, "`id`=".$cand["id_advertissement"]);
        $adv_cand_list = $_SESSION["DatabaseCore"]->select_fields('advertisements_candidature', '`id_advertissement`='.$cand['id_advertissement']);
        while(($adv_cand = $adv_cand_list->fetch()) != NULL)
            $_SESSION["DatabaseCore"]->update_fields('advertisements_candidature', $np, "`id`=".$adv_cand["id"]);
    }

    function test_run()
    {
        echo "The UserCore is Ok !<br>";
    }

}



$_SESSION["CompanyCore"] = new CompanyCore();
