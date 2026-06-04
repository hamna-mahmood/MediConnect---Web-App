<?php
$passwords = [
    'ashfaq1234',
    'bano1234',
    'rabia1234',
    'hamna1234',
    'komal1234',
    'emaan1234',
    'farah1234',
    'maryam1234',
    'alizafar',
    'mirtakimir',
    'atifaslam',
    'zahidahmed',
    'fawadkhan',
    'pharma1234'
];

foreach ($passwords as $p) {
    echo $p . " => " . password_hash($p, PASSWORD_DEFAULT) . "<br>";
}
