<?php

/**
 * Created by PhpStorm.
 * User: SASENSI
 * Date: 30/06/2016
 * Time: 13:54
 */
class ModelTableTest
{
	/**
	 * @var mixed
	 */
	protected $col1;

	/**
	 * @var mixed
	 */
	protected $col2;

	public function exchangeArray($arr)
	{
		$this->col1 = (isset($arr['col1'])) ? $arr['col1'] : null;
		$this->col2 = (isset($arr['col2'])) ? $arr['col2'] : null;
	}
}