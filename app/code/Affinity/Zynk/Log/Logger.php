<?php

namespace Affinity\Zynk\Log;

use Zend\Debug\Debug;

class Logger extends \Magento\Framework\Logger\Monolog
{
	/**
	 * {@inheritdoc}
	 */
	public function debug($message, array $context = array())
	{
		Debug::dump($message);
		return is_scalar($message)
			? parent::debug($message, $context)
			: parent::debug(Debug::dump($message, null, false), $context);
	}
}
