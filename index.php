<?php
include ("class.FractionMath.php");

$gg=new FractionMath();

$first="1 2/3";
$second="2 2/3";
echo "$first + $second = ";


//plus, minus, multiply, divide;
$gg->plus($first,$second);

echo $gg->getResult() ."<br><br>";
$gg->toMixed();
echo "to mixed not reduced: ".$gg->getResult() ."<br><br>";
echo "convert to fractions again: ".$gg->toFractions($gg->result) ."<br><br>";
$gg->reduceFraction();
echo "fractions reduced: ".$gg->getResult() ."<br><br>";
$gg->toMixed();
echo "from reduced to mixed: ".$gg->getResult() ."<br><br>";
echo "convert to fractions again: ".$gg->toFractions($gg->result);

echo "<br><br>";
echo "Whole number: ".$gg->getwhole() ." Fractions: " . $gg->getFractions() ." Numerator: " . $gg->getNumerator() . " Denominator: " . $gg->getDenominator();

echo "<br><br>";
$gg->toWhole();
echo "to Whole result: ".$gg->getResult();

?>
