<?php
require_once __DIR__ . '/../vendor/autoload.php';

//var_dump($_SERVER['REQUEST_URI']);die;
if($_SERVER['REQUEST_URI'] == '/home') {
    require __DIR__ . '/../app/controllers/homepage.php';
}
exit;

/**/