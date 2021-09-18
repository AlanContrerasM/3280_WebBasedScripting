<!--Ex2 Alan Contreras-->
<!DOCTYPE html>
<html lang='en' xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <p>Your Bill</p>

        <?php 
            $hamburger = 4.05;
            $milkShake = 1.95;
            $cola = 0.85;  //85 cents
            $tax_rate = 7.5/100; //This is a 7.5% tax rate
            $tip = 16/100; //16%, ugh tipping culture

            $cost = ((2*$hamburger) + $milkShake + $cola)* (1* $tip) *(1 * $tax_rate);
            

            print "<b>You must pay $" . $cost . ". </b>"; // . is for concatinating


        ?>


    </body>
</html>