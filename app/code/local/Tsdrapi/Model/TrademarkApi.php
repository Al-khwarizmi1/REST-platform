<?php

namespace local\Tsdrapi\Model;

use core\Master\Model\AbstractModel;
use local\Tsdrapi\lib\TsdrApi;

/**
* @TODO add registraton number searches
*/
class TrademarkApi extends AbstractModel
{
	
	protected $_api;
	
	public function __construct()
	{
		$this->_api = new TsdrApi();
		$this->_setupCacheDirectory();
		return;
	}
	
	public function getTmDataFromSerialNum($serial)
	{
		$rawResults = $this->_api->getTrademarkData($serial);
		$rawResults = array("status" => "success","data" => $rawResults); // wrapper
		return $rawResults;
	}
	
	// ============================= UTILITIES ============================= //
	
	private function _setupCacheDirectory()
	{
		$this->_api->setDir(VAR_DIR);
	}
}
