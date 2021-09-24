<!--Ex2 Alan Contreras-->
<!DOCTYPE html>
<html lang='en' xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <p>Your Bill</p>

        <?php 
            $hamburger = 4.05;
            $milkShake = 1.95;
            $cola = 0.85;  //85 cents
            $tax_rate = 7.5/100; //This is a 7.5% tax rate
            $tip = 16/100; //16%, ugh tipping culture
            $price1 = 50.34;
            $price2 = 49.34 + 1; //floating points might no always be equal like  .00000001 difference

            if(abs($price1-$price2) < 0.00001){//this is how you compare floating points
                print "same number <br>";
            }
            //if("05" == "5"){console.log("ok")}; //evaluates to true

            // for($min = 1, $max = 10; min <50; min += 10, max+=10){};

            // //true false excercise
            // // 100.00 - 100 false
            // // "zero" true
            // // "false" true 
            // // 0 + "true" true 
            // // 0.000 false
            // // "0.0" true

            //Array 
            $array1 = [5,4,"hi"];
            $array1[] ="this is like .push";
            $length = count($array1); //would return 4
            //in if an empty array returns false

            //to loop arrays in php
            print "<table>\n";
            foreach($array1 as $key => $value){
                print "<tr><td>$key</td><td>$value</td></tr>\n";
            }
            print "</table>\n";

            

            //Associative Array
            $vegetables['corn'] = "yellow";
            $vegetables['beet'] = "red";


            //console.table($vegetables);

            $dinner = array(0=> "mac and chees", 
                            'hi' => "something",
                            3 => "something else",
                        'with space' => "margharitas tequila");

            print "<table>\n";
            foreach($dinner as $key => $value){
                print "<tr><td>$key</td><td>$value</td></tr>\n";
            }
            print "</table>\n";

            print "<table>\n";
            foreach($dinner as $value){
                print "<tr><td>$value</td></tr>\n";
            }
            print "</table>\n";

            print "<h3> If array_key_exists()</h3>\n";

            if(array_key_exists('hi', $dinner)){
                print "Yes we have 'hi' <br>\n";
            }

            print "<h3> If in_array()</h3>\n";

            if(in_array("something", $dinner)){
                print "Yes something exists' <br>\n";
            }

            print "<h3> array_search() returns key</h3>\n";

            $dinnerKey = array_search("something", $dinner);
            if($dinnerKey){
                print "$dinnerKey value is 'something' <br>";
            }

            //for displaying arrays in string
            $world['foo'] = "Foo World!";
            $world['two'] = "extra world";
            $world["secret world"] = "Alan's world";
            
            print "Hello, $world[foo].\n<br>";
            print "Hello, $world[two].\n<br>";
            //for spaces, or in general, safer to use braces
            print "Hello, {$world["secret world"]}.\n<br>";

            $world[] = "new";
            print "Hello, $world[0].\n<br>";

            //to remove
            unset($world["two"]);

            //print all elements in an array use implode

            $galaxy = implode(', ', $world);
            print $galaxy . "<br>";

            //explode is to join strings into array explode(", ", $myArr)

            $lunches = [["hi","2"],["4","3"]];

            print $lunches[0][0] . "<br>";


            
            //print "{$dinner['with space']} is second plate<br>"
            // console.table($dinner);

            $cost = ((2*$hamburger) + $milkShake + $cola)* (1* $tip) *(1 * $tax_rate);
            

            print "<b>You must pay $" . $cost . ". </b>"; // . is for concatinating


        ?>


    </body>
</html>