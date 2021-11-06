<!-- calc_values(), 1 to 3 parameters, a, b , or c
1 param equals 1 statement, ++ | --
2 nd param +=, -=, *=, or /=, selected randomly. Ex. a+=b
3rd param rnadom =, -=, *=, or /=, b to c. Ex. b *= c;
return statement returns either a on first and second example, and b on third example
-->


<!-- evaluate_function. This function has 3 input parameters:  
i. an array containing the value of the arguments passed to the function (3,8,3 in the example top-
right) 
ii. a string indicating if the operator of the first statement is increment (++) or decrement(--) (in the 
first example above is ‘- -') 
iii. an array containing two operators’ symbols, the operator of the second and third statements ( 
*= and /= for the example on top-right)  -->


<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    //calling from lib.php
    display_html_head("300330244 Alan Contreras MT");
    generate_function();
    display_html_foot();


    //3 params, 1, arr of values params passed to the functions, 2 the first stastement ++|--, 3 arr with 2nd and 3rd param [+=, *=]
    function evaluate_function($values, $first, $secondAndThird){
        

        switch(count($values)){
            case 1:
                $a= $values[0];
                if($first == "++"){
                    $a++;
                    return $a;
                }else{
                    $a--;
                    return $a;
                }
                break;
            case 2:
                $a= $values[0];
                $b= $values[1];
                if($first == "++"){
                    $a++;
                }else{
                    $a--;
                }
                switch($secondAndThird[0]){
                    case "+=":
                        $b+=$a;
                        return $b;
                        break;
                    case "-=":
                        $b-=$a;
                        return $b;
                        break;
                    case "*=":
                        $b*=$a;
                        return $b;
                        break;
                    case "/=":
                        $b/=$a;
                        return $b;
                        break;
                            
                }

                break;
            case 3:
                $a= $values[0];
                $b= $values[1];
                $c= $values[2];
                if($first == "++"){
                    $a++;
                }else{
                    $a--;
                }
                switch($secondAndThird[0]){
                    case "+=":
                        $b+=$a;
                        break;
                    case "-=":
                        $b-=$a;
                        break;
                    case "*=":
                        $b*=$a;
                        break;
                    case "/=":
                        $b/=$a;
                        break;   
                }
                switch($secondAndThird[1]){
                    case "+=":
                        $c+=$b;
                        return $c;
                        break;
                    case "-=":
                        $c-=$b;
                        return $c;
                        break;
                    case "*=":
                        $c*=$b;
                        return $c;
                        break;
                    case "/=":
                        $c/=$b;
                        return $c;
                        break;
                            
                }
                break;
        }

        
    }

    function generate_function(){
        $white_4space = "&nbsp;&nbsp;&nbsp;&nbsp;"; 
        // $new_line = "<br />";really not needed, messes up my flow.
        //randomly selects 1-3 params
        $operator1 = array('++', "--");
        $operator2and3 = array('+=', '-=', '*=', '/=');

        $params = rand(1,3);
        $statement1 = $operator1[rand(0,1)];
        $statement2 = $operator2and3[rand(0,3)];
        $statement3 = $operator2and3[rand(0,3)];

        //calling the function, randomly between 0 and 10.
        $values = array(rand(0,10), rand(0,10), rand(0,10));


        switch($params){
            case 1:
                print "function calc_values(a) {<br/>";
                print $white_4space . "a$statement1;<br/>";
                print $white_4space . "return a;<br/>}<br/><br/>";
                print "y = calc_values($values[0]);<br/><br/>";
                break;
            case 2:
                print "function calc_values(a, b) {<br/>";
                print $white_4space . "a$statement1;<br/>";
                print $white_4space . "b $statement2 a;<br/>";
                print $white_4space . "return b;<br/>}<br/><br/>";
                print "y = calc_values($values[0], $values[1]);<br/><br/>";
                break;
            case 3:
                print "function calc_values(a, b, c) {<br/>";
                print $white_4space . "a$statement1;<br/>";
                print $white_4space . "b $statement2 a;<br/>";
                print $white_4space . "c $statement3 b;<br/>";
                print $white_4space . "return c;<br/>}<br/><br/>";
                print "y = calc_values($values[0], $values[1], $values[2]);<br/><br/>";
                break;
        }

        //call evaluate function 
        switch($params){
            case 1:
                $result = evaluate_function(array($values[0]), $statement1, array($statement2, $statement3));
                break;
            case 2:
                $result = evaluate_function(array($values[0], $values[1]), $statement1, array($statement2, $statement3));
                break;
            case 3:
                $result = evaluate_function($values, $statement1, array($statement2, $statement3));
                break;
        }

        print "After executing this piece of code, the value of y would be $result.";

    }



    
?>