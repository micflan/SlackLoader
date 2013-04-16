<?php

// Start it up.
require_once('../start.php');

// Punch it.
require_once(DIR . 'pagemaster.php');
start($slack->loadPage($pages));