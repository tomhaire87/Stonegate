<?php

namespace Affinity\Stonegate\Plugin\Magento\Widget\Model;

class Widget
{
	/**
	 * By default, the Magento image chooser inserts {{media url="wysiwyg/path/to/image.jpg"}} as a widget argument.
	 * The double quotes in the short-code break widget parsing in Magento's WYSIWYG.
	 * This plugin reduces the media arguments from "{{media url="wysiwyg/path/to/image.jpg"}}" to "wysiwyg/path/to/image.jpg" for easy parsing.
	 * All other arguments are left untouched.
	 * @param   \Magento\Widget\Model\Widget $subject
	 * @param   string $type
	 * @param   array $params
	 * @param   bool $asIs
	 * @return  array
	 */
	public function beforeGetWidgetDeclaration(\Magento\Widget\Model\Widget $subject, $type, $params = [], $asIs = true)
	{
		$newParams	= [];

		foreach($params as $paramKey => $paramValue) {
			if(strpos($paramValue,'/directive/___directive/') !== false) {
				$parts	= explode('/', $paramValue);
				$key	= array_search("___directive", $parts);
				if($key !== false) {
					$url	= $parts[$key+1];
					$url	= base64_decode(strtr($url, '-_,', '+/='));

					$parts	= explode('"', $url);
					$key	= array_search("{{media url=", $parts);
					$url	= $parts[$key+1];

					$paramValue	= $url;
				}
			}
			$newParams[$paramKey]	= $paramValue;
		}
		return array($type, $newParams, $asIs);
	}
}