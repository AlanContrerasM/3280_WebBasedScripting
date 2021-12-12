<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    //global database variable.
    $db;

    //calling from lib.php
    display_html_head("Alan Update");
    
    openDB();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //destructuring after validating form.
        list($errors, $inputs) = validate_form();
        if ($errors) {
            show_form($errors);
        } else {
            // print "no errors";
            process_form($inputs);
        }
    } else {
        // The form wasn't submitted, so display normal form without errors
        show_form();
    }
    
    
    display_html_foot();


    function process_form($inputs) {
        global $db;
        // Insert student into database
        try {
            //since birth date and gender can be null, 

            $stmt = $db->prepare('UPDATE Student SET StdID = ?, SName = ?, BirthDate = ?, Gender = ?, Department = ?
                                  WHERE StdID = ?');
            $stmt->execute(array($inputs['StdID'], $inputs['SName'], $inputs['BirthDate'], $inputs['Gender'], $inputs['Department'], $_GET['StdID']));
            // Tell the user that we added a dish.
            print "<span class='success'>Updated Student in the database.</span><br/><br/>";
            print "<a href='index.php'><<<<< Back To HomePage</a><br/><br/>";

        } catch (PDOException $e) {
            print "Couldn't update Student to Database. $e";
        }
    }



    function validate_form(){
        //array holders
        $errors = array();
        $inputs = array();

        //birthdate and gender can be null
        //studentid mmust be valid integer
        //department can only be MATH, PHYS, ART, CSIS
        //if error display it next to its field.

        //StdID
        $inputs['StdID'] = filter_input(INPUT_POST, 'StdID', FILTER_VALIDATE_INT);
        if(is_null($inputs['StdID']) || $inputs['StdID'] === false ){
            // $errors[] = "plase enter a valid price number";
            $errors['StdID'] = "*Plase enter a valid integer number for Student ID";
            // to display assoc array print "Hello, $world[foo].\n<br>";
        }


        // Name required
        $inputs['SName'] = trim($_POST['SName'] ?? '');
        if (! strlen($inputs['SName'])) {
            $errors['SName'] = "*Plase enter a non empty value for Name";
        }

        //Department
        $inputs['Department'] = trim($_POST['Department'] ?? '');
        //check if its empty
        if (! strlen($inputs['Department'])) {
            $errors['Department'] = "*Plase choose a correct value for Department";
        }

        //checking for options
        $valid_departments = ["MATH", "CSIS", "PHYS", "ART"];
        if (!in_array($inputs['Department'], $valid_departments)){
            $errors['Department'] = "*Plase choose one of the allowed values";
        }

        //BirthDate and Gender
        // print "birthdate: " . gettype($_POST['BirthDate']);
        //since it can be null
        $inputs['BirthDate'] = $_POST['BirthDate'] == "" ? null : $_POST['BirthDate'];
        $inputs['Gender'] = $_POST['Gender'] == "" ? null : $_POST['Gender'];
        
        
    
        return array($errors, $inputs);
    }

    function show_form($errors = array()){
        //get user info
        global $db;
        $stmt = $db->prepare("SELECT * FROM Student WHERE StdID = ?");
        $stmt->execute(array($_GET['StdID']));
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $student = $stmt->fetch();



        print <<<_HTML_
                <form method="POST" action="update.php?StdID=$_GET[StdID]">
                    <fieldset>
                    <legend>Enter the information about the Student: </legend>
                _HTML_;

        print "<label>Student ID: </label>
            <input type='text' value='$student->StdID' name='StdID'><span class='error'>$errors[StdID]</span><br/>";
                    

        print "<label>Name: </label>
            <input type='text' value='$student->SName' name='SName'><span class='error'>$errors[SName]</span><br/><br/>";

        print "<label>Birth Date: </label>
            <input type='date' value='$student->BirthDate' name='BirthDate'><br/>";

        //GENDER
        print "<label>Gender: </label><br/>
            <input type='radio' name='Gender' id='M' value='M'";
            print $student->Gender == 'M'? " checked>" : ">";
        print "<label for='M'>Male</label><br/>
            <input type='radio' name='Gender' id='F' value='F'";
            print $student->Gender == 'F'? " checked>" : ">";
        print "<label for='F'>Female</label><br/>
            <input type='radio' name='Gender' id='X' value='X'";
        print $student->Gender == 'X'? " checked>" : ">";
        print "<label for='X'>Other</label><br/>";

        print "<label>Department: </label>
            <select name='Department' >
                <option ";
                print $student->Department == 'MATH'? " selected " : "";
                print " value='MATH'>MATH</option>
                <option ";
                print $student->Department == 'CSIS'? " selected " : "";
                print "value='CSIS'>CSIS</option>
                <option "; 
                print $student->Department == 'ART'? " selected " : "";
                print "value='ART'>ART</option>
                <option "; 
                print $student->Department == 'PHYS'? " selected " : "";
                print "value='PHYS'>PHYS</option>
            </select><span class='error'>$errors[Department]</span><br/>";
            
            
            print <<<_HTML_
                    <button type="submit"> Submit </button>
                </fieldset>
            </form>
           _HTML_;
           print "<br/><br/><a href='index.php'><<<<< Back To HomePage</a><br/><br/>";
    }
    

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


     



?>