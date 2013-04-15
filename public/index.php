<?php

define(DIR, dirname(__FILE__) . '/');

// Set course
require_once(DIR . '../wordrelease.php');
$wordrelease = new Wordrelease($config, $pages);
$tmpl = $wordrelease->getTemplateVars();
$data = $wordrelease->getPostData();

// Punch it
if ($wordrelease->getTemplateHeader()) include(DIR . $wordrelease->getTemplateHeader());
include(DIR . $wordrelease->getTemplateBody());
if ($wordrelease->getTemplateFooter()) include(DIR . $wordrelease->getTemplateFooter());