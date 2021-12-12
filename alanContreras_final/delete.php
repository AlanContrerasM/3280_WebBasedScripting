<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    //global database variable.
    $db;

    //calling from lib.php
    display_html_head("Alan Delete");

    openDB();
    // print $_GET['StdID'];
    delete_row();
    
    
    display_html_foot();


    

    function openDB(){
        // using the global database
        global $db;
        try {
            $db = new PDO('mysql:host=localhost;dbname=3280db','root', '');
            // print "Successfully connected";
        } catch (PDOException $e) {
            print "Can't connect: " . $e->getMessage();
            print "<br/> please change: <h2>user and password</h2> for database connection on openDB function";
            exit();
        }
        // setting error modes.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    function delete_row(){
        try{
            global $db;

            //Prepared Statement, without sanitation with wildcards, etc.
            $stmt = $db->prepare("DELETE FROM Student WHERE StdID = ?");
            $stmt->execute(array($_GET['StdID']));

            //sanitized, not needed
            // $student = $db->quote($_GET['StdID']);
            // //string replace
            // $student = strtr($student, array('_' => '\_', '%' => '\%'));

            print "<span class='success'>Deleted Student $_GET[StdID] from the database.</span><br/><br/>";
            print "<a href='index.php'><<<<< Back To HomePage</a><br/><br/>";

            

        }catch(PDOException $e){
            print "Couldn't delete Student with ID : " . $e->getMessage();
        }
    }
     



?>


