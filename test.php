<?php

require __DIR__ . '/vendor/autoload.php';

var_dump(class_exists('Config\DatabaseConnection')); // Debe retornar `true`
var_dump(file_exists(__DIR__ . '/Config/DatabaseConnection.php'));
