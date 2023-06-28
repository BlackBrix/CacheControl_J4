<?php
/**
 * @package     CacheControl
 * @author      Crosstec GmbH & Co. KG
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
 * @note        Modified by SharkyKZ
*/
defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Registry\Registry;

return new class ($dispatcher, $app, $params) implements PluginInterface
{
	private $caching = 0;
	private $dispatcher;
	private $app;
	private $params;

	public function __construct(DispatcherInterface $dispatcher, CMSApplicationInterface $app, Registry $params)
	{
		$this->dispatcher = $dispatcher;
		$this->app = $app;
		$this->params = $params;
	}

	public function onAfterRoute(): void
	{
		if ($this->app->isClient('site') && $this->checkRules())
		{
			$this->caching = $this->app->get('caching');
			$this->app->set('caching', 0);
		}
	}
	
	public function onAfterDispatch(): void
	{
		if ($this->app->isClient('site') && $this->params->def('reenable_afterdispatch', 0) && $this->checkRules())
		{
			$this->app->set('caching', $this->caching);
		}
	}
	
	private function checkRules(): bool
	{
		$defs = str_replace("\r", "", $this->params->def('definitions',''));
		$defs = explode("\n", $defs);
		$input = $this->app->getInput();

		foreach ($defs as $def)
		{
			parse_str($def, $result);

			if (is_array($result))
			{
				$found = 0;
				$required = count($result);

				foreach ($result as $key => $value)
				{
					if ($input->get($key, null, 'UNKNOWN') == $value || ($input->get($key, null, 'UNKNOWN') !== null && $value == '?'))
					{
						$found++;
					}
				}
				if ($found == $required)
				{
					return true;
				}
			}
		}
	
		return false;
	}

    public function setDispatcher(DispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    public function registerListeners(): void
    {
        $this->dispatcher->addListener('onAfterRoute', [$this, 'onAfterRoute']);
        $this->dispatcher->addListener('onAfterDispatch', [$this, 'onAfterDispatch']);
    }
};
