<?php
// adds time strings. returns time string
function timeAdd($a, $b) : string {
    $start = "";
    $lengt = "";
        if (preg_match("`^[0-9]+:..$`", $a)) {
            $a .= ":00";
        }
        if (preg_match("`^[0-9]+:..$`", $b)) {
            $b .= ":00";
        }
// file_put_contents('php://stderr', print_r([$a,$b], TRUE));
        $start = DateTime::createFromFormat("!H:i:s", $a);
        $lengt = DateTime::createFromFormat("!G:i:s", $b);
// file_put_contents('php://stderr', print_r([$start,$lengt], TRUE));
    $lengtInt = DateInterval::createFromDateString(3600+$lengt->getTimestamp()." seconds");
// file_put_contents('php://stderr', print_r($lengtInt, TRUE));
    // $lengt = $lengt->getTimestamp();
    // $start->modify("+".$lengt." seconds");
    $start->add($lengtInt);

    return $start->format("H:i");
}

function isInRange($start, $end, $time) {
    $inRange = false;
// file_put_contents('php://stderr', print_r([$start,$end,$time], TRUE));

    $start = DateTime::createFromFormat("!H:i:s", $start);
    $end = DateTime::createFromFormat("!H:i:s", $end);
    $time = DateTime::createFromFormat("!H:i", $time);

    if ($start <= $time && $time < $end) {
        $inRange = true;
    }
// file_put_contents('php://stderr', print_r(($start <= $time && $time < $end) ? "true\n" : "false\n", TRUE));

    return $inRange;
}