<?php
namespace Main;
final class DeveloperDB
{
    private string $servername;
    private string $db_username;
    private string $db_password;
    private string $dbname;


    public function __construct($servername = "localhost", $db_username = "csiger", $db_password = "", $dbname = "phpdatabase")
    {
        $this->servername = $servername;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
        $this->dbname = $dbname;
    }

    public function GetServerName()
    {
        return $this->servername;
    }
    public function GetDbUsername()
    {
        return $this->db_username;
    }
    public function GetDbPassword()
    {
        return $this->db_password;
    }
    public function GetDbName()
    {
        return $this->dbname;
    }
}
?>