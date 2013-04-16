<!DOCTYPE html>

<!--[if lt IE 7 ]> <html lang="en-US"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en-US"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-US"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-US"> <![endif]-->
<!--[if gt IE 9]><!--><html lang="en-US"><!--<![endif]-->

<head id="www-sitename-com" data-template-set="html5-reset-wordpress-theme" profile="http://gmpg.org/xfn/11">

    <meta charset="UTF-8">

    <title><?=$data['page_title'];?> &mdash; <?=$data['site_title'];?></title>

    <meta name="title" content="<?=$data['page_title'];?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:500,600,800" type="text/css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="alternate" type="application/rss+xml" title="<?=$data['page_title'];?> Feed" href="/feed/" />

</head>

<body id="<?=$data['page_id'];?>" class="<?=$data['page_class'];?>">

    <div id="header-wrap">

        <div class="heroWrap">
            <h1><a href="/"><?=$data['site_title'];?></a></h1>
            <p><?=$data['site_description'];?></p>
            <p>
                <a href="<?=$data['site_address'];?>">Blog</a> &#8226; 
                <a href="http://twitter.com/">Twitter</a> &#8226; 
                <a href="http://github.com/">GitHub</a>
            </p>
            <p><a href="/about">About / Contact</a></p>
        </div>

    </div>

    <div id="content">
