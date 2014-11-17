<?php
if(file_exists(__DIR__."/../config/settings.local.php")){
	$config=include(__DIR__."/../config/settings.local.php");
} else if(file_exists(__DIR__."../config/settings.dist.php")){
	$config=include(__DIR__."/../config/settings.dist.php");
} 