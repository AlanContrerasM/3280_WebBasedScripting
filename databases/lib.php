<?php

function display_html_head($title = 'Default Title'){
    print <<<HEREDOC


        <!DOCTYPE html>
        <html lang='en' >
            <head>
                <meta charset="utf-8" />
                <title>$title</title>
            </head>
            <body>
        
       HEREDOC;
}

function display_html_foot(){
    print <<<HEREDOC
        </body>
        </html>
       HEREDOC;
}


?>