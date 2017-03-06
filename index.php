<?php
require 'vendor/autoload.php';
//ini_set('display_errors', '1');
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Define constants:
define("DS", "\\", true);
define("VAR_DIR", dirname(__FILE__).DIRECTORY_SEPARATOR."var".DIRECTORY_SEPARATOR);

$app->any('/{module}/{controller}/{action}[/{params:.*}]', function (Request $request, Response $response) 
{
	$module = ucfirst($request->getAttribute('module'));
	$controller = ucfirst($request->getAttribute('controller', 'Index'));
	$action = $request->getAttribute('action', "Index") . "Action";
	
	$class = "local".DS.$module.DS."controllers".DS.$controller;

	// Parse parameters if they exist
    $path = trim($request->getAttribute('params', ''), '/');
    $params = array();
    if($path !== "")
    {
    	$params = explode('/', $path ? $path : '');
    	for ($i = 0, $l = sizeof($params); $i < $l; $i += 2)
    	{
    		$params['params'][$params[$i]] = isset($params[$i + 1]) ? urldecode($params[$i + 1]) : '';
    	}
    	$params = $params['params'];
    }    

	// Handle Classes not found here
	if(!class_exists($class))
	{
		// @TODO how to handle unkown classes? Default noRoute || return false JSON ??		
		return "Class not found";
	}
	
	$contollerInstance = new $class($request, $response, $params);
	if(!$contollerInstance instanceof core\Master\Controller\ControllerInterface)
	{
		return "Error: invalid controller instance";
	}
	
	// Handle unkown methods here
	if(!method_exists($contollerInstance, $action))
	{
		// @TODO how to handle unkown classes? Default noRoute || return false JSON ??
		return "action not found";
	}
	// @TODO move this to the response object
	// needed for angular to accept requests
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
	return $contollerInstance->$action();
});

$app->run();