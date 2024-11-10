<?php
namespace Main;
use PDOException;
use PDO;
final class DeveloperDB
{
    private static string $servername;
    private static string $db_username;
    private static string $db_password;
    private static string $db_name;
    private static string $PDO_name = "sqlite:Blogger.db";
    public const FETCH_ASSOC = PDO::FETCH_ASSOC;
    public const PARAM_STR = PDO::PARAM_STR;

    public static function CallPDO()
    {
        try{
        $db = new PDO(dsn: self::$PDO_name);
        $db->exec('PRAGMA foreign_keys = ON;');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
        }catch(PDOException $e){
            echo 'Nem létezik PDO adatbázis!';
            exit();
        }
    }
}
?>