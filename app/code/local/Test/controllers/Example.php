<?php
namespace local\Test\controllers;

use core\Master\Controller\AbstractController;

class Example extends AbstractController
{
	public function testAction()
	{
		$hello = "Hello World";
		$this->getResponseObj()->getBody()->write($hello);
	}
}