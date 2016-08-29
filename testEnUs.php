<?php

require_once('vendor/autoload.php');

$num = 123456789;

$words = new \Numbers\Words();
echo $words->toCurrency($num);
