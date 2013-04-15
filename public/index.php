<?php

// Set course
require_once('../wordrelease.php');
$wordrelease = new Wordrelease($config, $pages);
$tmpl = $wordrelease->getTemplateVars();
$data = $wordrelease->getPostData();

// Punch it
if ($wordrelease->getTemplateHeader()) include($wordrelease->getTemplateHeader());
include($wordrelease->getTemplateBody());
if ($wordrelease->getTemplateFooter()) include($wordrelease->getTemplateFooter());