<?php
    //Alan Contreras 
    //300330244
    require 'lib.php';

    

    //global variable degree, holds the max level of exponent we are going to use
    $degree = 2;
    //holds how many terms we want in our expression
    $num_of_terms = 2 * $degree + 3;

    //calling from lib.php
    display_html_head("300330244 Alan Algebra Class!");
    display_expression($degree);
    display_html_foot();


    function generate_expression($degree){
        $coefficients = array();
        $exponents = array();

        //we call rand() for coefficients rand(-20,20)
        //for exponents rand(0, $degree)
        //reset num_of_terms incase $degreee was reseted at one point, like if we sent a form with new degree
        //just a failsafe
        $GLOBALS['num_of_terms'] = 2 * $degree + 3;

        for($i=0; $i < $GLOBALS['num_of_terms']; $i++){
            //coefficients should exclude 0
            $options = array(rand(-20,-1), rand(1,20));
            
            $coefficients[$i] = $options[rand(0,1)];
            $exponents[$i] = rand(0,$degree);
            // echo "generate $i, $coefficients[$i]:$exponents[$i]<br/>";
        }


        $terms = array($coefficients, $exponents);
        return $terms;

    }

    function meet_requirements($terms, $degree){
        //check if there is at least two terms of each degree
        //we already have our keys in a certain way
        //set the degree as the key, and value, will be the # of occurrences
        $exponents = array();

        for($i = 0; $i < count($terms[1]); $i++){
            $exp_key = $terms[1][$i];

            if(array_key_exists($exp_key, $exponents)){
                $exponents[$exp_key]++;
            }else{
                $exponents[$exp_key] = 1;
            }
            
        }

        // foreach($exponents as $key => $value){
        //     print "$key: $value<br/>";
        // }

        //compare the size, to degrees, if equal we continue comparing
        if(count($exponents) === $degree + 1){
            //now let's count if each has at least 2 occurrences
            $valid = true;
            foreach($exponents as $value){
                if($value < 2){
                    $valid = false;
                }
            }
            if($valid){
                return true;
            }
        }


        return false;
    }

    function print_expression($terms){
        //print everything
        //<sup> tag is for exponents
        //handle signs, don't put a positive isng on first term
        //if coefficient is one, but has a degree we just write x
        //we dont write degree 1 as x^1 

        $expression = ""; //testing 4x + 5x<sup>8</sup>
        //how many terms we have
        for($i = 0; $i < count($terms[0]); $i++){
            $coef = $terms[0][$i];
            $exp = $terms[1][$i];

            

            if($coef !== 0){
                //check for signs
                if($coef < 0){
                    $expression .= " - ";
                }else{
                    if($i !== 0){
                        $expression .= " + ";
                    }
                    
                }

                $coef = abs($coef);
                //if its 1x, no need just x
                if(!($coef === 1 && $exp > 0)){
                    $expression .= "$coef";
                }


                //check for exponent degree
                if($exp > 0){
                    $expression .= "x";
                    if($exp>1){
                        $expression .= "<sup>$exp</sup>";
                    }
                }

            }

        }

        print <<<_HTML_
                    <form method="POST" action="$_SERVER[PHP_SELF]">
                        <span>$expression</span> = <input type="text" name="my_name" />
                        <input type="hidden">
                        <button type="submit">Checkl</button>
                    </form>
                _HTML_;
        

    }

    function display_expression($degree){

        $valid = false;
        $terms = generate_expression($degree);
        while(!$valid){
            if(meet_requirements($terms, $degree)){
                $valid = true;
            }else{
                $terms = generate_expression($degree);//
            }
        }
        

        //print generated terms
        print_expression($terms);


    }

?>