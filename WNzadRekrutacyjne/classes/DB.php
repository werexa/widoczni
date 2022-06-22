<?php

/**
 * Definicja brakujacej funkcji w SQLITE POW
 */
function sqlite_pow($number, $e)
{
    return pow($number, $e);
}

//---------------------------------
//UNIWERSALNE ŁĄCZENIE SIĘ Z BAZĄ
//---------------------------------

class Db
{

    private static function instance()
    {
        try {
            $myPDO = new PDO('sqlite:' . dirname(__FILE__) . '/exampleDB.db');
            $myPDO->sqliteCreateFunction("POW", "sqlite_pow", 2);
            $myPDO->query('SET NAMES utf8');
            $myPDO->query('SET CHARACTER_SET utf8_unicode_ci');
            $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $ex) {
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }

        return $myPDO;
    }





    /**
     * 
     */
    public static function executeS($sql)
    {

        $myPDO = self::instance();
        $stm = $myPDO->prepare($sql);
        if ($stm->execute()) {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            if (!$result)
                return array();
            return $result;
        }

        return array();
    }

    /**
     * 
     */
    public static function execute($sql)
    {

        $myPDO = self::instance();
        if($myPDO->exec($sql))
        {
            //logs
            $txt = file_get_contents(dirname(__FILE__).'/logs.txt');
            file_put_contents(dirname(__FILE__).'/logs.txt',"OK :". $txt."\n".$sql); //implode(', ', $row), FILE_APPEND);
            return true;
            
        }

        return false;
        
        
    }

    /**
     * Pobiera cały wiersz
     *
     * @param string $sql
     * @return array|bool
     */
    public static function getRow($sql)
    {
        $myPDO = self::instance();
        $sql = rtrim($sql, " \t\n\r\0\x0B;") . ' LIMIT 1';
        $stm = $myPDO->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_NAMED);
        return $result;
    }

    /**
     * Pobieranie jednej wartości
     * @param string $sql - kwerenda
     * @return array|false 
     */
    public static function getValue($sql)
    {
        $result = self::getRow($sql);
        if ($result == false)
            return false;

        return array_shift($result);
    }

    /**
     * Pobieranie wartości danej zmiennej konfiguracyjnej
     * @param string $config_name
     */
    public static function getConfig($config_name)
    {
        return self::getValue("SELECT $config_name FROM refferals_config");
    }
    /**
     * Pobieranie wszystkich wartości  konfiguracyjnych
     */
    public static function getConfigs()
    {
        return self::getRow("SELECT * FROM refferals_config");
    }

    /**
     * Wprowadzenie do bazy danych
     * @param array $data - tablica asoc
     * @param string $table - 
     * @param string $type - INSERT, REPLACE 
     */
    protected static function insert($data, $table,$type = "INSERT")
    {
        if($type != "INSERT" && $type != "REPLACE")
            return false;

        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            array_push($keys, $key);
            array_push($values, (gettype($value) == "string")? "$value":$value);
        };
        $keys_str = implode(",", $keys);
        $values_str = implode(",", $values);
        return self::execute("$type INTO $table ($keys_str) VALUES($values_str)");
    }

    /**
     * Aktualizacja tabeli
     * @param array $data - tabelka asoc 
     * @param string $table - nazwa tabeli w DB
     * @param string $where - schemat typu column = 'value' lub column > value  , bez WHERE
     */
    protected static function update($data, $table, $where = "")
    {
        $sql = "UPDATE $table SET ";
        $set = [];
        foreach ($data as $key => $value) {
            array_push($set, "$key = '$value'");
        }

        if(strlen(trim($where))>0 && !empty($where))
            $where = "WHERE $where";

        $sql .= implode(",", $set) . "  $where";
        return self::execute($sql);
    }

    /**
     * Usunięcie danych z tabeli 
     * @param string $table - nazwa tabeli
     * @param string $where - shemat sql where 
     */
    protected static function delete($table, $where)
    {
        if (!empty($where))
            self::execute("DELETE FROM $table WHERE $where");
    }
}
