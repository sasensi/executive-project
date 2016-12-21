<?php

namespace Application\Model;

interface RowInterface
{
	/**
	 * @param array $data
	 */
	public function exchangeArray($data);
}