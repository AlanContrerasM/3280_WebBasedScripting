<?php
// Refactoring by alan contreras
require "lib.php";
display_html_head("Algebraic Expressions");
$degree = 2;  // the degree of an expression. Just change this degree and the whole program works based on the 
// $num_of_terms = 2 * $degree + 3;  // number of terms generated not needed anymore


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
        global $degree;
        $degree = $inputs['my_degree'];

        $expr = new Expression($degree);
        $expr->generate();


        display_form($degree);
        display_expression("The Generated Expression:", $expr->stringify());
        //simplify it here and store it in $expr_simplified_str
        // I set $expr_simplified_str="" because you must complete the code and set $expr_simplified_str to the simplified string.
        $expr_simplified_str ="";
        display_expression("Its Simplified Version:",  Expression::simplify($expr)->stringify());
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



class Term{
    public $coefficient;
    public $exponent;

    
}

class Expression{
    const coefficient_min = -20;
    const coefficient_max = 20;
    public $terms;
    public $degree;
    public $num_of_terms;

    public function __construct($degree){
        $this->degree = $degree;
        $this->num_of_terms = 2 * $this->degree + 3;
        $this->terms = array();
    }

    public function generate(){
        $degree = $this->degree;
        $excluded = [0];
        do {
            // $this->terms = null;
            $this->terms = array();
            

            for ($i = 0; $i < $this->num_of_terms; $i++) {
                do {
                    $coefficient = rand(self::coefficient_min, self::coefficient_max);
                } while (in_array($coefficient, $excluded));
                $exponent = rand(0, $degree);
                //create new term, and assign values
                $newTerm = new Term;
                $newTerm->coefficient = $coefficient;
                $newTerm->exponent = $exponent;
                //add to array
                $this->terms[] = $newTerm;
            }
        } while (!$this->meets_requirements($this->terms, $degree));  // re-generate expression if it does not meet the requirement
        
        
        return $this->terms;
    }

    public function stringify(){
        $expression = "";
        $terms = $this->terms;
        // strigify the first term as it is different that the other trms- the sign (- or +) is connected to the number, also if there is only 
        // one term, no + or - sign is needed after 
        if ($terms[0]->coefficient != 0) {
            if ($terms[0]->exponent == 0) {
                $expression .= $terms[0]->coefficient;
            } else if ($terms[0]->coefficient == 1) {
                $expression .= stringify_term($terms[0]->exponent);;
            } else if ($terms[0]->coefficient == -1) {
                $expression .= "-" . stringify_term($terms[0]->exponent);;
            } else {
                $expression .= $terms[0]->coefficient . stringify_term($terms[0]->exponent);
            }
        }
        // strigify the rest of the terms
        for ($i = 1; $i < count($terms); $i++) {
            if ($terms[$i]->coefficient == 0) {
                continue;
            } else if ($terms[$i]->coefficient < 0) {
                $expression .= " - ";
            } else if ($terms[$i]->coefficient > 0) {
                $expression .= " + ";
            }
            if ($terms[$i]->exponent == 0) {
                $expression .= abs($terms[$i]->coefficient);
            } else if (abs($terms[$i]->coefficient) == 1) {
                $expression .= stringify_term($terms[$i]->exponent);;
            } else {
                $expression .= abs($terms[$i]->coefficient) . stringify_term($terms[$i]->exponent);
            }
        }
        
        return $expression;

        
    }

    public function meets_requirements(){
        

        for ($deg = $this->degree; $deg >= 0; $deg--) {
            $isValid = false;
            $counter = 0;
            for ($i = 0; $i < $this->num_of_terms; $i++) {
                if ($this->terms[$i]->exponent == $deg) {
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

    public static function simplify($expression){
        $newExpr = new Expression($expression->degree);
        
        for ($deg = $expression->degree; $deg >= 0; $deg--) {
            $sum = 0;
            for ($i = 0; $i < $expression->num_of_terms; $i++) {
                if ($expression->terms[$i]->exponent == $deg) {
                    $sum += $expression->terms[$i]->coefficient;
                }
            }
            if($sum != 0){
                $newTerm = new Term;
                $newTerm->coefficient = $sum;
                $newTerm->exponent = $deg;
                $newExpr->terms[] = $newTerm;
            }
            
        }

        $newExpr->num_of_terms = count($newExpr->terms);
        return $newExpr;
    }

    
}

?>