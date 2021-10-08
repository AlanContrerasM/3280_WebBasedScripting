<?php
    file_get_contents('page.html');
    file_put_contents('page.html', $data_to_pass);

    // to read line by line
    foreach(file('people.txt') as $line){
        $line = trim($line);
        $info = explode('|', $line);
        print '<li><a href="mailto: ' . $info[0] . '">' . $info[1] . "</li>\n";  
    }

    // all file have file permissions, we also need permissions to do certain things
    // php engine is treated as a user
    // // fopen(), feof(), fgets()
    // fopen() opens as a stream
    // 
    $fh = fopen('people.txt', 'rb'); //read binary, if wanna treat it as text instead of binary just write r instead of rb
    //different modes r:read w:write a:append x:exist c:create +:read+write
    //
    //feof, is file end of file, so if its not end of file, we assign it to $line with fgets()
    while((! feof($fh)) && ($line = fgets($fh))){
        $line = trim($line);
        $info = explode('|', $line);
        print '<li><a href="mailto: ' . $info[0] . '">' . $info[1] . "</li>\n";  
    }
    fclose($fh);

    //file_get_contents() returns string
    //file() returrns array
    //fope() returns a stream, pointer

    //fwrite(), doesnt asdd automatic line at the end of string you write
    $filename = 'text.txt';
    $somecontent = "dd this to the file\n";

    if(is_writable($filename)){
        //append mode, so pointer is at the end
        if(!$handle = fopen($filename, 'a')){//append mode
            echo 'cannot open file ($filename)';
            exit;
        }

        if (fwrite($handle, $somecontent) === FALSE){
            echo 'cannot write to file ($filename)';
            exit;
        }

        echo "Success, wrote ($somecontent) to file ($filename)";
        fclose($handle);
    }else{
        echo 'the file $filename is not writable';
    }


    //cs, comma separated values
    // fgetcsv(
    //     resource $stream,
    //     int $length = 0,
    //     string $separator = ",",
    //     string $enclosure = '""',
    //     string $escape = "\\"
    // ): array

    $row = 1;
    if(($handle = fopen('test.csv', 'r'))!== FALSE){
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $num = count($data);
            echo "<p> $num fields in line $row: <br/></p>\n";
            $row++;
            for($c =0; $c < $num; $c++){
                echo $data[$c] . "</br>\n";
            }
        }
        fclose($handle);
    }

    //checking for erros
    if(file_exists('/usr/local/htdocs/index.html')){
        print 'index file is there';
    }else{
        print 'No index file is there';
    }

    $template_file = 'page.html';
    if(is_readable($template_file)){
        $template = file_get_contents($template_file);
    }else{
        print 'cant read';
    }



    $fh = fopen('somefile.txt', 'rb');
    if(! $fh){
        print "Error opening people.txt: $php_errormsg";
    }else{
        //do stuff
    }
    if( !fclose($fh)){
        print "Error closing people.txt: $php_errormsg";
    }

 ?>