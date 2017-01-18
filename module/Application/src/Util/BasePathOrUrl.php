<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Application\Util;


use Zend\View\Helper\AbstractHelper;

class BasePathOrUrl extends AbstractHelper
{
	public function __invoke($file = null)
	{
		if (strpos($file, 'http') === 0)
		{
			return $file;
		}

		return $this->view->basePath($file);
	}

}