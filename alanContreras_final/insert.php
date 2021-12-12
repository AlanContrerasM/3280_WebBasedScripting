<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    //global database variable.
    $db;

    //calling from lib.php
    display_html_head("Alan Insert");
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //destructuring after validating form.
        list($errors, $inputs) = validate_form();
        if ($errors) {
            show_form($errors);
        } else {
            // print "no errors";
            openDB();
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

            $stmt = $db->prepare('INSERT INTO Student (StdID, SName, BirthDate, Gender, Department)
                                  VALUES (?,?,?,?,?)');
            $stmt->execute(array($inputs['StdID'], $inputs['SName'], $inputs['BirthDate'], $inputs['Gender'], $inputs['Department']));
            // Tell the user that we added a dish.
            print "<span class='success'>Added Student $inputs[StdID]: $inputs[SName] to the database.</span><br/><br/>";
            print "<a href='index.php'><<<<< Back To HomePage</a><br/><br/>";

        } catch (PDOException $e) {
            print "Couldn't add new Student to Database. $e";
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


        print <<<_HTML_
            <form method="POST" action="$_SERVER[PHP_SELF]">
                <fieldset>
                <legend>Enter the information about the Student: </legend>
                    <label>Student ID: </label>
                    <input type='text' name='StdID'><span class='error'>$errors[StdID]</span><br/>

                    <label>Name: </label>
                    <input type='text' name='SName'><span class='error'>$errors[SName]</span><br/><br/>

                    <label>Birth Date: </label>
                    <input type='date' name='BirthDate'><br/>

                    <label>Gender: </label><br/>
                    <input type="radio" name="Gender" id="M" value="M">
                    <label for="M">Male</label><br/>
                    <input type="radio" name="Gender" id="F" value="F">
                    <label for="F">Female</label><br/>
                    <input type="radio" name="Gender" id="X" value="X">
                    <label for="X">Other</label><br/>

                    <label>Department: </label>
                    <select name="Department" >
                        <option value='MATH'>MATH</option>
                        <option value='CSIS'>CSIS</option>
                        <option value='ART'>ART</option>
                        <option value='PHYS'>PHYS</option>
                    </select><span class='error'>$errors[Department]</span><br/>
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