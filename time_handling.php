<?php
// adds time strings. returns time string
function timeAdd($a, $b) : string {
    $start = DateTime::createFromFormat("!H:i", $a);
    $lengt = DateTime::createFromFormat("!G:i", $b);
    $lengtInt = DateInterval::createFromDateString(3600+$lengt->getTimestamp()." seconds");
    // $lengt = $lengt->getTimestamp();
    // $start->modify("+".$lengt." seconds");
    $start->add($lengtInt);

    return $start->format("H:i");
}