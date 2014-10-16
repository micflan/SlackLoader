<?php

error_reporting(-1);

// Start it up.
require_once('../app/start.php');


// Punch it.
require_once(DIR . 'pagemaster.php');
$slack->loadPage($pages);
start($slack);
