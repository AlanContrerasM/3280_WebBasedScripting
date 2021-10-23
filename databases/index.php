<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    
    //calling from lib.php
    display_html_head("Databases Title");
    display_html_foot();
    print "<h1>Hi</h1>";
    // open_db();
    // open_create_database();
    // drop_table();
    // update_row();
    // delete_row();


    //3 steps, open, work close db.

    function open_db(){
        //create a PDO object, it takes a data source name, which db to connect, and then value pairs

        //DSN prefixes and opions: mysql, pgsql, oci, sqlite, odbc, mssql, stbase, dblib
        //$db = new PDO('mysql:host=db.example.com;dbname=restaurant','penguin', 'top^hat');
        ///'ds:host;dbname'       ,   'username'    ,     'password'
        //you can set them on php my admin, databases, usernames, passwords, for what host, etc.
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            // $db = new PDO('mysql:host=localhost;dbname=test','test', 'te'); //this one throws an error
        }catch(PDOException $e){
            print "Couldn't connect to the database: " . $e->getMessage();
        }
        
    }

    function open_create_database(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //with these attributes we can get error messages, 
            //we could set it to ERRMODE_WARNING, but not recommended if you are a beginner.
            $q = $db->exec("CREATE TABLE dishes (

                dish_id INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
                dish_name VARCHAR(255),
                price DECIMAL(4,2),
                is_spicy INT
            )");  

            //to insert
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy)
                            VALUES ('Sesame Seed Puff', 2.50, 0)");
                            //if we are inserting into all columns, (dish_name, etc) not needed just specify values in order.
            //returns number of rows affected on affectedRows
            
            //we can also get errors when exec has an error it returns false. won't be executed, cause first if there is an error,
            // it will get thrown as an exception first, and we will go to catch, this is more for warning, or silent mode.
            if(false === $affectedRows){
                $error = $db->errorInfo();
                print "Couldn't insert!\n";
                print "SQL error={$error[0]}, DB Error={$error[1]}, Message{$error[2]}/n";
            }

            
        }catch(PDOException $e){
            print "Couldn't create table, and insert rows.: " . $e->getMessage();
        }
    }

    function drop_table(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $db->exec("DROP TABLE dishes");
        }catch(PDOException $e){
            print "Couldn't drop table: " . $e->getMessage();
        }
        

    }

    function update_row(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $db->exec("UPDATE dishes SET is_spicy = 1
                            WHERE dish_id = 1");
        }catch(PDOException $e){
            print "Couldn't update table: " . $e->getMessage();
        }
    }

    function delete_row(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $db->exec("DELETE FROM dishes WHERE dish_id = 1");

            //remove al dishes
            // $q = $db->exec("DELETE FROM dishes");
        }catch(PDOException $e){
            print "Couldn't update table: " . $e->getMessage();
        }
    }

    function insert_from_form_unsanitized(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $q = $db->exec("INSERT INTO dishes (dish_name)
                            VALUES('$_POST[new_dish_name]')");
            //this is dangerous as its open for sql injection, also if there is an extra ' or " it can also mess you up
            //clean it first
        }catch(PDOException $e){
            print "Couldn't update table: " . $e->getMessage();
        }
    }



?>