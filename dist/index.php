<?php
/*
Sure, I could use an MVC like Zend Framework 2 or Laravel,
but... you don't always need the complexity.
*/
require_once __DIR__.'/../vendor/autoload.php';

$page='';
if(!empty($_GET["page"])) {
	# The _GET parameter has been cleaned at this point
    $page=$_GET["page"];
}

require_once 'layout/header.php';

## page routing go here
if(!empty($page)) {
    if (file_exists("pages/" . $page . ".php"))
        require_once "pages/".$page.".php";
} else {
        require_once "pages/home.php";
}

require_once 'layout/footer.php';
