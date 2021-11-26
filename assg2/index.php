<?php
// By Alan Contreras
require "lib.php";
display_html_head("Algebraic Expressions");
$degree = 2;  // the degree of an expression. Just change this degree and the whole program works based on the 
$num_of_terms = 2 * $degree + 3;  // number of terms generated


//1. depending if first time loading, ideally should be a function, for it to be cleaner...
if('POST' == $_SERVER['REQUEST_METHOD']){
    //check for errors
    list($form_errors, $inputs) = validate_form();

    if($form_errors){
        print "please correct these errors: <ul><li>";
        print implode('</li><li>', $form_errors);
        print '</li></ul>';
        display_form($inputs['my_degree']);
    }else{
        global $degree, $num_of_terms;
        $degree = $inputs['my_degree'];
        $num_of_terms = 2 * $degree + 3;
        display_form($degree);
        $expr = generate_expression($degree);
        $expr_str = stringify_expression($expr);
        display_expression("The Generated Expression:", $expr_str);
        //simplify it here and store it in $expr_simplified_str
        // I set $expr_simplified_str="" because you must complete the code and set $expr_simplified_str to the simplified string.
        $expr_simplified_str ="";
        display_expression("Its Simplified Version:",  $expr_simplified_str);
    }
    
    
}else{
    display_form($degree);
}





display_html_foot();

function display_form($default_degree){
// you must complete this function
// use HEREdoc to display the <label> and <input> and <form>

    print <<<_HEREdoc_
            <div>Select the degree of the expression: </div><br/>
            <form method="POST" action="$_SERVER[PHP_SELF]">
                <label>Degree: </label> = <input type="text" name="my_degree" value="$default_degree" />
                <button type="submit">Generate</button>
            </form>
        _HEREdoc_;
    
}

function display_expression($caption, $expr_str)
{
    print <<<_EXPR
    <div>
    <label>$caption</label><span>$expr_str</span><br />
    </div>
    _EXPR;
}


// verify if a term with each degree appears at least 2 times
function meets_requirements($terms, $degree)
{
    for ($deg = $degree; $deg >= 0; $deg--) {
        $isValid = false;
        $counter = 0;
        for ($i = 0; $i < $GLOBALS['num_of_terms']; $i++) {
            if ($terms[1][$i] == $deg) {
                $counter++;
                if ($counter == 2) {
                    $isValid = true;
                    break;
                }
            }
        }
        if (!$isValid) {
            break;
        }
    }
    return $isValid;
}


// generates an expression with a given degree
function generate_expression($degree)
{
    $excluded = [0];
    do {
        for ($i = 0; $i < $GLOBALS['num_of_terms']; $i++) {
            do {
                $coefficient = rand(-20, 20);
            } while (in_array($coefficient, $excluded));
            $exponent = rand(0, $degree);
            $terms[0][$i] = $coefficient;
            $terms[1][$i] = $exponent;
        }
    } while (!meets_requirements($terms, $degree));  // re-generate expression if it does not meet the requirement
    return $terms;
}


// convert an expresssion represented by a two dimensional array to a string
function stringify_expression($terms)
{
    $expression = "";
    // strigify the first term as it is different that the other terms- the sign (- or +) is connected to the number, also if there is only 
    // one term, no + or - sign is needed after 
    if ($terms[0][0] != 0) {
        if ($terms[1][0] == 0) {
            $expression .= $terms[0][0];
        } else if ($terms[0][0] == 1) {
            $expression .= stringify_term($terms[1][0]);;
        } else if ($terms[0][0] == -1) {
            $expression .= "-" . stringify_term($terms[1][0]);;
        } else {
            $expression .= $terms[0][0] . stringify_term($terms[1][0]);
        }
    }
    // strigify the rest of the terms
    for ($i = 1; $i < count($terms[0]); $i++) {
        if ($terms[0][$i] == 0) {
            continue;
        } else if ($terms[0][$i] < 0) {
            $expression .= " - ";
        } else if ($terms[0][$i] > 0) {
            $expression .= " + ";
        }
        if ($terms[1][$i] == 0) {
            $expression .= abs($terms[0][$i]);
        } else if (abs($terms[0][$i]) == 1) {
            $expression .= stringify_term($terms[1][$i]);;
        } else {
            $expression .= abs($terms[0][$i]) . stringify_term($terms[1][$i]);
        }
    }
    return $expression;
}


// stringifies only one term
function stringify_term($exponent)
{
    $term = "";
    if ($exponent == 1)
        $term .= "x";
    else if ($exponent > 1)
        $term .= "x" . "<sup>$exponent</sup>";
    return $term;
}

function validate_form(){
    //array of errors in case there are
    $errors = array();
    $inputs = array();

    //we can also add optional ranges
    $inputs['my_degree'] = filter_input(INPUT_POST, 'my_degree', FILTER_VALIDATE_INT, array('options'=> array('min_range'=> 0)));

    if(is_null($inputs['my_degree']) || ($inputs['my_degree'] === false)){
        $errors[] = "plase enter a valid number bigger than 0";
    }
    
    return array($errors, $inputs);
}