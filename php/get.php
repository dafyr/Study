

<p>Введите число</p>

<form>

<input name="num" type="number">
<input type="submit">
    
</form>

<?php



if ($_GET["num"]) {

$check = gmp_prob_prime($_GET["num"]);

if ($check == 0) {
    
    echo ("Число простое");
    
}

else if ($check == 1) {
    
    echo ("Число возможно простое");
    
}

else {
    
    echo ("Число не простое");
    
}
}

$_GET["num"] = "";

?>