<?php

if('POST' == $_SERVER['REQUEST_METHOD']){
    print "<p>Hello, ";
    //Print what was submitted in the form parameter caller "user"
    print $_POST['user'];
    print "!</p>";
}else{
    print <<<HEREDOC
        <form method="POST" action="$_SERVER[PHP_SELF]">
            Your Name: <input type="text" name="user" />
            </br>
            <button type="submit"> Say Hello</button>
        </form>
       HEREDOC;
}

// useful server variables
print '<br/>_SERVER uses<br/>';
print 'SERVER_NAME and PATH_INFO: ' . $_SERVER['SERVER_NAME'] . $_SERVER['PATH_INFO'];
print '<br/>';
print 'QUERY_STRING: ' . $_SERVER['QUERY_STRING'];
print '<br/>';
print 'DOCUMENT_ROOT: ' . $_SERVER['DOCUMENT_ROOT'];
print '<br/>';
print 'REMOTE_ADDR: ' . $_SERVER['REMOTE_ADDR'];
print '<br/>';
print 'REMOTE_HOST: ' . $_SERVER['REMOTE_HOST'];
print '<br/>';
print 'HTTP_PREFERER: ' . $_SERVER['HTTP_PREFERER'];
print '<br/>';
print 'HTTP_USER_AGENT: ' . $_SERVER['HTTP_USER_AGENT'];
print '<br/>';

print '<br/>';
//print 'Ternary and Coalesce Operator';
print '<br/>';
$ternary = true ? true : false;
$coallesce  = true ?? false; //returns the value if it exists and not null, if not returns false

//elements with multiple values

if('POST' == $_SERVER['REQUEST_METHOD']){
    print "<p>Tasty, ";
    //Print what was submitted in the form parameter caller "user"
    if(isset($_POST['lunch'])){
        foreach ($_POST['lunch'] as $choice){
            print "chose: $choice <br/>";
        }
    }
}else{
    print <<<HEREDOC
        <form method="POST" action="$_SERVER[PHP_SELF]">
            <select name="lunch[]" multiple >
                <option value="pork">Pork</option>
                <option value="chicken">chicken</option>
                <option value="tofu">Tofu</option>
            </select>
            <button type="submit"> Send choices</button>
        </form>
       HEREDOC;
}

print '<br/>';
print '<br/>';
print '<br/>';









//try to use this format

if('POST' == $_SERVER['REQUEST_METHOD']){
    if(validate_form()){
        process_form();
    }else{
        show_form();
    }
    
}else{
    show_form();
}

function validate_form(){
    if(strlen($_POST['my_name']) < 3){
        return false;
    }else{
        return true;
    }
}
function process_form(){
    print "Hello, " . $_POST['my_name'];
}

function show_form(){
    print <<<_HTML_
        <form method="POST" action="$_SERVER[PHP_SELF]">
            Your Name: <input type="text" name="my_name" />
            </br>
            <button type="submit"> Say Hello</button>
        </form>
       _HTML_;
}


//validating data more thorough with errro messaging
print '<br/>';
print '<br/>';
print 'With error messaging exhaustive, and ';
print '<br/>';

if('POST' == $_SERVER['REQUEST_METHOD']){
    list($form_errors, $inputs) = validate_form1();
    if($form_errors){
        show_form1($form_errors);
        
    }else{
        process_form1($inputs);
    }
    
}else{
    show_form1();
}



function validate_form1(){
    //array of errors in case there are
    $errors = array();
    $inputs = array();

    if($inputs['name'] = trim($_POST['my_name']) ?? ''){
        if(strlen($inputs['name'] ==0)){
            $errors[] = "Your name must not be empty";
        }elseif(strlen($inputs['name'] < 3)){
            $errors[] = "Your name must be at least 3 letters long";
        }

    }
    //validate a number integer or float php has predefined helpers
    $inputs['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);

    //we can also add optional ranges
    $inputs['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, array('options'=> array('min_range'=> 18,
                                                                                                    'max_range' => 65)));

    if(is_null($inputs['age']) || ($inputs['age'] === false)){
        $errors[] = "plase enter a valid age";
    }
    //validate a number integer or float php has predefined helpers
    $inputs['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT); //could be FILTER_VALIDATE_FLOAT
    //to validate a range in float we need to do it manually, like adding to the if || $inputs['price'] < 10.0 || $inputs['price'] > 100)
    if(is_null($inputs['price']) || ($inputs['price'] === false)){
        $errors[] = "plase enter a valid price number";
    }

    //validate emails
    $inputs['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); //could be FILTER_VALIDATE_FLOAT
    if(! ($inputs['email'])){
        $errors[] = "plase enter a valid email";
    }
    return array($errors, $inputs);
}

function process_form1($inputs){
    //print "Hello, " . $_POST['my_name'];
    print "Hello, $inputs[name], $inputs[age], $inputs[price]. ";
}

function show_form1($errors = null){
    if($errors){
        print "please correct these errors: <ul><li>";
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }
    print <<<_HTML_
        <form method="POST" action="$_SERVER[PHP_SELF]">
            Your Name: <input type="text" name="my_name" />
            </br>
            Your Age: <input type="text" name="age" />
            </br>
            Your price: <input type="text" name="price" />
            </br>
            Your email: <input type="text" name="email" />
            <button type="submit"> Say Hello</button>
        </form>
       _HTML_;
}


    //to validate selects we creat an array and from that array we generate the form and 
    //to validate we check if post is included in our original options

    // $inputs['order'] = $_POST['order']; 
    // if(! in_array($inputs['order'], $GLOBALS['orders'])){
    //     $errors[] = "plase choose a valid order";
    // }

    //if you have a comment section or something where a user can write javascript or html user 
    // $comments = htmlentities(($_POST['comments']));

    print rand(5,8);

?>