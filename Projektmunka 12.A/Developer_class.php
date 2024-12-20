<?php
namespace Main;
use PDOException;
use PDO;

final class DeveloperDB
{
    private static $servername;
    private static $db_username;
    private static $db_password;
    private static $db_name;
    private static $PDO_name = "sqlite:Blogger.db";
    public const FETCH_ASSOC = PDO::FETCH_ASSOC;
    public const PARAM_STR = PDO::PARAM_STR;

    public static function CallPDO()
    {
        try {
            $db = new PDO(self::$PDO_name);
            $db->exec('PRAGMA foreign_keys = ON;');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            return 'Hiba a PDO adatbázissal! '.$e->getMessage();
        }
    }
}
