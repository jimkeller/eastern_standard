<?php

class DB {

    static $DB_name='employee_management';
    static $Connection;

    public static function connect() {

        if ( !self::$Connection) {
            self::$Connection = new PDO('mysql:host=localhost;dbname=' . self::$DB_name, 'root', '');
        }

        return self::$Connection;
    }
    
}