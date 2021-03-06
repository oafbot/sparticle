<?php
/**
 *  LAIKA FRAMEWORK Release Notes:
 *
 *  @filesource     Mysql.php
 *
 *  @version        0.1.0b
 *  @date           2011-05-21 03:53:51 -0400 (Sat, 21 May 2011)
 *
 *  @author         Leonard M. Witzel <witzel@post.harvard.edu>
 *  @copyright      Copyright (c) 2011  Laikasoft <{@link http://oafbot.com}>
 *
 */
/**
 *  Laika_Mysql_Driver class.
 *
 *  Database wrapper object using mysqli
 * 
 *  Unimplemented.
 *  
 *  @package        Laika
 *  @subpackage     util
 *  @category       database
 *
 *  @extends        Laika_Singleton
 *  @implements     Laika_Interface_DB_Driver
 */
class Laika_Mysql_Driver extends Laika_Singleton implements Laika_Interface_DB_Driver{

    protected static $instance;
    private   static $connection;

    public static function connect(){
        $mysql = self::init();
        $mysql::$connection = new mysqli($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $db=DB_NAME, $port=DB_PORT);
        return $mysql::$connection;
    }
    public static function disconnect(){}
    
    public function select_by(){}
    public function select_all($table){}
    
    public function update(){}
    public function insert(){}
    public function create(){}
    public function add(){}
    public function delete(){}
    
    //public function get_num_rows(){}
    //public function get_error(){}
   // public function free_result(){}
}