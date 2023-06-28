<?php
/**
 * @copyright   (C) 2023 SharkyKZ
 * @license     GNU General Public License; see LICENSE
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Registry\Registry;

return new class implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            static function (Container $container)
            {
                $dispatcher = $container->get(DispatcherInterface::class);
                $app = Factory::getApplication();
                $params = new Registry(PluginHelper::getPlugin('system', 'cachecontrol')->params ?? '{}');

                return require JPATH_PLUGINS . '/system/cachecontrol/cachecontrol.php';;
            }
        );
    }
};
