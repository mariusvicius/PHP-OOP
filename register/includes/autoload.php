<?php

spl_autoload_register('classesAutoLoader');

function classesAutoLoader($className){
	$className 	= ltrim($className, '\\');
    $fileName  	= '';
    $namespace 	= '';
	$dir 		= __DIR__.'/classes/';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	
	if (!file_exists($dir.$fileName)) {
        return false;
    }

    require $dir.$fileName;
}

function baseurl(){
    $host  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $baseurl = "http://" . $host . $path;
}
?>