<?php

include "config.php";

class Conexion{

//    private $connection;
    private $_host;
    private $_database;
    private $_user;
    private $_pass;
    private $_port;

    private $_mngDB;

    /**
     * @return el manejador de la conexión a la BBDD
     */
    public function get_mngDB(){
        return $this->_mngDB;
    }

    /**
     * Conexion constructor.
     * @param string $host
     * @param string $database
     * @param string $user
     * @param string $pass
     * @param string $port
     */
    public function __construct()
    {
        $this->_host=HOST;
        $this->_database=DBNAME;
        $this->_user=USER;
        $this->_pass=PASS;
        $this->_port=PORT;

        $dsn = 'mysql:host='.$this->_host.';'.'dbname='.$this->_database.';'.'port='.$this->_port;

        try{
            $this->_mngDB = new PDO($dsn, $this->_user, $this->_pass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }catch(PDOException $e){
            printf('Conexión con la base de datos fallida: '.$e);
        }
    }

    public function consulta($sql, $values = array()){

        $result=false;
        if(($_stmt = $this->_mngDB->prepare($sql))){
            if(preg_match_all('/(:\w+)/', $sql, $_named, PREG_PATTERN_ORDER)){
                $_named = array_pop($_named);
                foreach ($_named as $_param) {
                    $_stmt->bindValue($_param, $values[substr($_param, 1)]);
            }

            }
        }
        try{
            if(!$_stmt->execute()){
                printf('Error en la ejecucción de la consulta: %\n', $_stmt->errorInfo()[2]);
            }
            $result = $_stmt->fetchAll(PDO::FETCH_ASSOC);
            $_stmt->closeCursor();
        }catch (PDOException $e){
            printf('Error en la consulta: %s\n', $e->getMessage());
        }

        return $result;
    }

    public function last_id(){
        return $this->_mngDB->lastInsertId();
    }

}