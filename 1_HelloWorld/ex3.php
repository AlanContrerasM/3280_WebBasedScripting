<?php
function countdown3(int $counter){
        while($counter > 0){
            print "$counter..";
            $counter--;
        }
        print "boom!<br/>";
    }
?>