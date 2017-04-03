<?php

namespace core\Master\Controller;

interface ControllerInterface
{	
	/**
	 * Loads request, resposne, and url parameters to all controller objects
	 * 
	 * @param \Psr\Http\Message\ServerRequestInterface $req
	 * @param \Psr\Http\Message\ResponseInterface $res
	 */
	public function __construct(\Psr\Http\Message\ServerRequestInterface $req, \Psr\Http\Message\ResponseInterface $res, Array $urlParams);
	
	/**
	 * @return \Psr\Http\Message\ServerRequestInterface
	 */
	public function getRequestObj();
	
	/**
	 * @return \Psr\Http\Message\ResponseInterfac
	 */
	public function getResponseObj();
	/**
	 * @return Array urlParams
	 */
	public function getUrlParams();
	/**
	 * @return String method
	 */
	public function getHttpMethod();
	
	/**
	 * @return Unknown bodyParsed data sent from the client via http post request
	 */
	public function getPostRequestBody();
}