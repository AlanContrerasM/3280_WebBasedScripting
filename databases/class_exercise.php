<?php
    //Alan Contreras 
    //300330244

use function PHPSTORM_META\type;

require 'lib.php';

    
    //calling from lib.php
    display_html_head("Databases Title");
   
    print "<h1>Class exercise</h1>";
    set_up();
    //1. list dishes asc order
    list_sort_price();
    print "<br/>";
    //2. form for minimum price
    price_form_ex();

    print "<br/>";
    //3. select form, selects dishname and retrieve all info
    select_form_ex();

    display_html_foot();

    



    function set_up(){
        //let's try to delete table if it exist already
        drop_table();
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //with these attributes we can get error messages, 

            $q = $db->exec("CREATE TABLE dishes (

                dish_id INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
                dish_name VARCHAR(255),
                price DECIMAL(4,2),
                is_spicy INT
            )");  

            //to insert
            //not needed to add the id, as we set auto_increment, but if not autoincrement, just add in values (1, 'Waln...)
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('Walnut Bun', 1.00, 0)");
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('Cashew Nuts and White Mushrooms', 4.95, 0)");
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('Dried Mulberries', 3.00, 0)");
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('Eggplant with Chili Sauce', 6.50, 1)");
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('Red Bean Bun', 1.00, 0)");
            $affectedRows = $db->exec("INSERT INTO dishes (dish_name, price, is_spicy) VALUES ('General Tso''s Chicken', 5.50, 1)");
              
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


    //1. list and sort by price
    function list_sort_price(){
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //by default fetch mode gives associative values and index
            $q = $db->query("SELECT dish_name, price, is_spicy FROM dishes ORDER BY price ASC");// DESC
            print "<h2>List sorted by price</h2><br/>";
            while ($row = $q->fetch()){
                print "$row[dish_name], \$$row[price], spicyness $row[is_spicy] <br/>";
            }
        }catch(PDOException $e){
            print "Couldn't select from table: " . $e->getMessage();
        }

    }

    //2. form asking for price, print names and prices who are above that price
    function price_form_ex(){


        if('POST' == $_SERVER['REQUEST_METHOD']){
            list($form_errors, $inputs) = validate_form();
            if($form_errors){
                show_form($form_errors);
                
            }else{
                process_form($inputs);
            }
            
        }else{
            show_form();
        }
        
    }

    function process_form($inputs){
        //print "Hello, " . $_POST['my_name'];
        print "Hello,minimum price set at: $inputs[price]. ";
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //prepare and sanitize querys wildcards for strings, not needed here since its number
            // $price = $db->quote($inputs['price']);
            // //string replace
            // $price = strtr($price, array('_' => '\_', '%' => '\%'));
            
            
            
            
            $q = $db->prepare("SELECT dish_name, price, is_spicy FROM dishes WHERE price > ?");
            $q->execute(array($inputs['price']));
            print "<h2>List where price is bigger than $inputs[price] </h2><br/>";
            while ($row = $q->fetch()){
                print "$row[dish_name], \$$row[price], spicyness $row[is_spicy] <br/>";
            }
        }catch(PDOException $e){
            print "Couldn't select from table: " . $e->getMessage();
        }
    }

    function validate_form(){
        //array of errors in case there are
        $errors = array();
        $inputs = array();
        
        //validate a number integer or float php has predefined helpers
        $inputs['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT); //could be FILTER_VALIDATE_FLOAT
        //to validate a range in float we need to do it manually, like adding to the if || $inputs['price'] < 10.0 || $inputs['price'] > 100)
        if(is_null($inputs['price']) || ($inputs['price'] === false || $inputs['price'] < 0.1 || $inputs['price'] > 10)){
            $errors[] = "plase enter a valid price number";
        }
    
        return array($errors, $inputs);
    }

    function show_form($errors = null){
        if($errors){
            print "please correct these errors: <ul><li>";
            print implode('</li><li>', $errors);
            print '</li></ul>';
        }
        print <<<_HTML_
            <form method="POST" action="$_SERVER[PHP_SELF]">
                Minimum price: <input type="number" step="0.01" name="price" />
                <button type="submit"> Get dishes</button>
            </form>
           _HTML_;
    }


    //3. form with a select that asks user which dish to show
    function select_form_ex(){


        if('POST' == $_SERVER['REQUEST_METHOD']){
            list($form_errors, $inputs) = validate_form3();
            if($form_errors){
                show_form3($form_errors);
                
            }else{
                process_form3($inputs);
            }
            
        }else{
            show_form3();
        }
        
    }

    function show_form3($errors = null){
        if($errors){
            print "please correct these errors: <ul><li>";
            print implode('</li><li>', $errors);
            print '</li></ul>';
        }
        //select from will be created by dish_name from db 
        $options = "";
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //by default fetch mode gives associative values and index
            $q = $db->query("SELECT dish_name FROM dishes");
            
            while ($row = $q->fetch()){
                $options .= "<option value='$row[dish_name]'>$row[dish_name]</option>";
            }
            

        }catch(PDOException $e){
            print "Couldn't select from table: " . $e->getMessage();
        }




        print <<<_HTML_
            <form method="POST" action="$_SERVER[PHP_SELF]">
                <select name="dishes[]" multiple >
                    
                    $options
                    
                </select>
                <button type="submit"> Select </button>
            </form>
           _HTML_;
    }

    function validate_form3(){
        //array of errors in case there are
        $errors = array();
        $inputs = array();

        //check if its not null
        if(isset($_POST['dishes'])){
            foreach ($_POST['dishes'] as $choice){
                if($inputs[$choice] = trim($choice) ?? ''){
                    if(strlen($inputs[$choice] ==0)){
                        $errors[] = "something is wrong here.";
                    }elseif(strlen($inputs[$choice] < 3)){
                        $errors[] = "Your choice must be at least 3 letters long";
                    }
            
                }
            }
        }else{
            $errors[] = "please make at least one choice";
        }
        
        
    
        return array($errors, $inputs);
    }

    function process_form3($inputs){
        //print "Hello, " . $_POST['my_name'];
        print "Hello, number of choices: " . count($inputs) ;
        try{
            $db = new PDO('mysql:host=localhost;dbname=test','test', 'test');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach ($inputs as $choice){
                try{
                    // prepare and sanitize querys wildcards for strings, only needed when not using prepared statements.
                    $dish = $db->quote($choice);
                    //string replace
                    $dish = strtr($dish, array('_' => '\_', '%' => '\%'));

                    print $dish;
                    print "<br/>";
                    //check prof provided examples
                    $q = $db->prepare("SELECT dish_id, dish_name, price, is_spicy FROM dishes WHERE dish_name LIKE ?");
                    // $q->execute([$dish]); //maybe not working since quote adds quotes.... yep... 
                    $q->execute([$choice]);
                    
                    // $q = $db->query("SELECT * FROM dishes WHERE dish_name = $dish"); //if not using prepared statements this work.
                    
                    
                    $dishes = $q->fetchAll();

                    if (count($dishes) == 0) {
                        print 'No dishes matched.';
                    } else {
                        
                        foreach ($dishes as $dish) {
                            if ($dish->is_spicy == 1) {
                                $spicy = 'Yes';
                            } else {
                                $spicy = 'No';
                            }
                            print "$dish[dish_name], \$$dish[price], spicyness $spicy: $dish[is_spicy] <br/>";
                        }
                    }

                    // if(empty($row)){print "empty";};


                    // if($q->execute([$dish])){
                        
                    //     while ($row = $q->fetch()){
                    //         print "$row[dish_name], \$$row[price], spicyness $row[is_spicy] <br/>";
                    //     }
                    // }else{
                    //     print "Error";
                    // }
                    
                    // while ($row = $q->fetch()){
                    //     print "$row[dish_name], \$$row[price], spicyness $row[is_spicy] <br/>";
                    // }

                }catch(PDOException $e){
                    print "Couldn't find that choice: " . $e->getMessage();
                }
            }
            
            
            
        }catch(PDOException $e){
            print "Couldn't select from table: " . $e->getMessage();
        }
    }




?>