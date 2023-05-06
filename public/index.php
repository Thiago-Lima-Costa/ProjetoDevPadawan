<?php

require '../vendor/autoload.php';
require '../app/helpers/whoops.php';

use app\router\Bootstrap;

checkSession();

activityCheck();

autoLoginAttempt();

Bootstrap::execute();


?>