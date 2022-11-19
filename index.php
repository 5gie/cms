<?php

session_start();

require_once('./vendor/autoload.php');
require_once('./config/parameters.php');

new \Src\App();
?>