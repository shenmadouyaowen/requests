<?php

// First, include Requests
include('../library/Requests.php');
include('../library/config.php');
// Next, make sure Requests can load internal classes
Requests::register_autoloader();
Requests::find('../library/xbongbong/');
//$list  = Customer::largelist();
$list  = Contact::largelist();
print_r($list);
//Customer::simpleList();
