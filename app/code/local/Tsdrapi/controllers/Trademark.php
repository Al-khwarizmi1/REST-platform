<?php

namespace local\Tsdrapi\controllers;

use core\Master\Controller\AbstractController;
use local\Tsdrapi\Model\TrademarkApi;

class Trademark extends AbstractController
{
	private $_errorLog = "trademark_search_errors.log";
	
	/**
	 * Grabs trademark results based on REST url
	 * 
	 * example: http://www.myapidomain.com/tsdrapi/trademark/serial/num/87132144
	 * where num/87132144 are Key/Value pairs
	 * 
	 * @return JSON
	 */
	public function serialAction()
	{
		$params = $this->getUrlParams();
		if ($params['num'])
		{
			$api = new TrademarkApi();
			try 
			{
				$trademarkData = $api->getTmDataFromSerialNum($params['num']);
				return $this->getResponseObj()->withJson($trademarkData);
			}
			catch (\Exception $e)
			{
				$fail = array(
						"status"	=> "fail",
						"data"		=> array(
								"title" 	=> "Exception thrown",
								"detail"	=> "Unable to find trademark"
						)
				);
				$this->logError($e->getMessage(), $this->_errorLog);
				return $this->getResponseObj()->withJson($fail);
			}
		}
		else 
		{
			$fail = array(
					"status"	=> "fail",
					"data"		=> array(
							"title" 	=> "Invalid parameter",
							"detail"	=> "Parameter 'num' not specified"
					)
			);
			return $this->getResponseObj()->withJson($fail);
		}
	}
}


