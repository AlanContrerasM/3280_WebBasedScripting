<?php
    $input_file = "addresses.txt";
    $output_file = "addresses_count.txt";

    $emails = [];
    $output_str = '';

    if(file_exists($input_file)){
        if($in_f = fopen($input_file, 'r')){
            while(!feof($in_f) && $line = fgets($in_f)){
                $line = trim($line);
                if(array_key_exists($line, $emails)){
                    $emails[$line]++;
                }else{
                    $emails[$line] = 1;
                }
            }
        }
    } else{
        print "The file '" . $input_file . "' does not exist.";
    }
    asort($emails);//asort is for array, ascending, arsort, descending
    foreach($emails as $email_addr => $email_count){
        $output_str .= $email_addr . ', ' . $email_count . "\n";
    }
    if($out_f = fopen($output_file, 'w')){
        if(fwrite($out_f, $output_str) === false){
            print "Cannot write to file ($output_file).";
        }
    }
    if(! fclose($out_f)){
        print "cannot close the file ($output_file) .";
    }
    if(! fclose($in_f)){
        print "cannot close file ($input_file) .";
    }
?>