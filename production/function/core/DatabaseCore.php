<?php

if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

$_SESSION["dirmaster"] = $_SERVER['DOCUMENT_ROOT']."/PWeb/production/";
require_once($_SESSION["dirmaster"]."function/core/IndexCore.php");

class DatabaseCore {
    private $pdo = null;
    public $stmt = null;
    public $error = "";
    public $dbg = false;

    /*
    ** Function to define the database
    */
    function define_database($file)
    {
        $obj = json_decode(file_get_contents($file));
        define("DB_HOST_INDEXCORE", $obj->db_url);
        define("DB_NAME_INDEXCORE", $obj->db_name);
        define("DB_CHARSET_INDEXCORE", $obj->db_charset);
        define("DB_USER_INDEXCORE", $obj->db_login);
        define("DB_PASSWORD_INDEXCORE", $obj->db_password);
        $GLOBALS['KEY'] = $obj->key;
        $GLOBALS['EXT'] = $obj->ext;
    }

    /*=================BASIC==================*/
    function __construct () {
        try {
            $this->define_database($_SESSION["dirmaster"]."database.json");
            $this->pdo = new PDO(
                "mysql:host=".DB_HOST_INDEXCORE.";dbname=".DB_NAME_INDEXCORE.";charset=".DB_CHARSET_INDEXCORE,
                DB_USER_INDEXCORE, DB_PASSWORD_INDEXCORE, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (Exception $ex) { exit($ex->getMessage()); }
    }

    function __destruct () {
        if ($this->stmt !== null) { $this->stmt = null; }
        if ($this->pdo !== null) { $this->pdo = null; }
    }

    function exec ($sql, $data=null) {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($data);
            return true;
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            return false;
        }
    }

    /*
    ** get l'id la dernière insertion
    */
    function lastId()
    {
        return $this->pdo->lastInsertId();
    }

    /*
    ** quote l'element passé en param
    */
    function quote($elem)
    {
        return $this->pdo->quote($elem);
    }

    function insert_fields($table, $fields)
    {
        $first_part = "INSERT INTO `".$table."` (";
        $second_part = 	"VALUES (";
        foreach ($fields as $index => $value)
        {
            $fields[$index] = strip_tags($fields[$index]);
            $fields[$index] = $this->quote($fields[$index]);
            $first_part = $first_part."`".$index."`, ";
            $second_part = $second_part."\"{$value}\", ";
        }
        $first_part = substr($first_part, 0, -2);
        $second_part = substr($second_part, 0, -2);
        $first_part = $first_part.")";
        $second_part = $second_part.")";
        $sql = $first_part." ".$second_part;
        if ($this->dbg) echo $sql;
        if ($this->exec($sql) == true)
            return $this->lastId();
        return -1;
    }

    function update_fields($table, $fields, $cond = -89)
    {
        $first_part = "UPDATE `".$table."` SET ";
        $second_part = ($cond == -89) ? "WHERE 1;" : "WHERE ".$cond.";";
        foreach ($fields as $index => $value)
        {
            $fields[$index] = strip_tags($fields[$index]);
            $fields[$index] = $this->quote($fields[$index]);
            $first_part = $first_part."`".$index."`=\"".$value."\", ";
        }
        $first_part = substr($first_part, 0, -2);
        $sql = $first_part." ".$second_part;
        if ($this->dbg) echo $sql;
        if ($this->exec($sql) == true)
            return $id;
        return -1;
    }

    function select_fields($table, $cond)
    {
        $sql = "SELECT * FROM `".$table."` WHERE ".$cond.";";
        if ($this->dbg) echo $sql;
        if ($this->exec($sql) == true)
            return $this->stmt;
        return -1;
    }

    function delete_fields($table, $cond)
    {
        $sql = "DELETE FROM `".$table."` WHERE ".$cond.";";
        if ($this->dbg) echo $sql;
        if ($this->exec($sql) == true)
            return $this->stmt;
        return -1;
    }

    function test_run()
    {
        echo "The DatabaseCore is Ok !<br>";
    }

}



$_SESSION["DatabaseCore"] = new DatabaseCore();
