<?php
function display_html_head($title){
    print <<<_HTML_HEAD
    <!doctype html>
    <html>
    <head>
        <title>$title</title>
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>

    _HTML_HEAD;
}

function display_html_foot(){
    print <<<_HTML_FOOT
    </body>
    </html>
    _HTML_FOOT;
}