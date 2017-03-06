<?php
namespace core\Master\Controller;

use core\Master\Controller\ControllerInterface;

// @TODO add json preperation abstraction
abstract class AbstractController implements ControllerInterface
{
	private $_request;
	private $_response;
	private $_urlParams;
	private $_logDir = VAR_DIR . "log";
	
	public function __construct(\Psr\Http\Message\ServerRequestInterface $req, \Psr\Http\Message\ResponseInterface $res, Array $urlParams = array())
	{
		$this->_request = $req;
		$this->_response = $res;
		$this->_urlParams = $urlParams;
	}
	
	public function getRequestObj()
	{
		return $this->_request;
			
	}
	
	public function getResponseObj()
	{
		return $this->_response;
	}
	
	public function getUrlParams()
	{
		return $this->_urlParams;
	}
	
	public function logError($message, $filename)
	{
		if (!file_exists($this->_logDir) && !is_dir($this->_logDir))
		{
			mkdir($this->_logDir);
		}
		
		$preMsg = "ERROR: " .date('Y-m-d H:i:s').": ";
		error_log($preMsg . $message . "\n", 3, VAR_DIR . "log" .DIRECTORY_SEPARATOR . $filename);
	}
}