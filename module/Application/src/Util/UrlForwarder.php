<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\Util;
use Zend\Http\Request;

/**
 * allow forwarding a target URL through a login process
 */
class UrlForwarder
{
	const GET_KEY = 'urlForward';

	/**
	 * include target as URL parameter in given URL
	 *
	 * @param string $url
	 * @param string $targetUrl
	 * @return string
	 */
	public static function storeTargetInUrl($url, $targetUrl)
	{
		$request = Request::fromString($url);
		$request->getQuery()->set(self::GET_KEY, $targetUrl);

		return $request->getUriString();
	}

	/**
	 * @param string $url
	 * @return mixed
	 */
	public static function getTargetFromUrl($url)
	{
		$request = Request::fromString($url);
		return $request->getQuery()->get(self::GET_KEY);
	}
}