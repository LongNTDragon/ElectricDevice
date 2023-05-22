<?php
    class Database
    {
        public static function connectDB($db_host, $db_user, $db_pass, $db_name)
        {
            $dsn = "mysql:host=$db_host;dbname=$db_name;charset=UTF8";
            try
            {
                return new PDO($dsn, $db_user, $db_pass);
            }
            catch(Exception $ex)
            {
                return $ex->getMessage();
            }
        }
    }
?>