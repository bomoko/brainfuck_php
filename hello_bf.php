<?php
include("vendor/autoload.php");


$bf = new \App\Brainfuck(trim(file_get_contents('./example/hw.bf')));
$bf->run();



