<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    //global database variable.
    $db;

    //calling from lib.php
    display_html_head("Alan Contreras Final");
    //change user or password for database connection professor, right now user is root, no password.
    openDB();
    print "<a href='insert.php'>Add New Student</a><br/><br/>";
    retrieve_data();
    
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


     //retrieving data
    function retrieve_data(){
        global $db;
        //No need for prepared statements since we are not passing conditionals to query
        try{
            $q = $db->query("SELECT * FROM Student");
            $q->setFetchMode(PDO::FETCH_OBJ);
            $students = $q->fetchAll();

            if(count($students) == 0){
                print "No Records Found!";
            }else{
                //print table headers
                print "<table><thead><tr>
                    <th>StudentID</th><th>Name</th><th>Birth Date</th><th>Gender</th><th>Department</th><th></th>
                </tr></thead>";

                print "<tbody>";
                //for loop each student on database
                foreach ($students as $student) {
                    print "<tr>";
                    print "<td>$student->StdID</td>";
                    print "<td>$student->SName</td>";
                    print "<td>$student->BirthDate</td>";
                    print "<td>$student->Gender</td>";
                    print "<td>$student->Department</td>";
                    print "<td><a href='delete.php?StdID=$student->StdID'>Delete</a>
                    <a href='update.php?StdID=$student->StdID'>Update</a></td>";
                    
                    
                    print "</tr>";
                }


                print "</tbody></table>";

            }
            
        }catch(PDOException $e){
            print "Couldn't select from table: " . $e->getMessage();
        }
    }



?>