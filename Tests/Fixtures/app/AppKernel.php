<?php
/**
 * Class AppKernel
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Fixtures\app;

use MauroMoreno\FindBundle\FindBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 * @package MauroMoreno\FindBundle\Tests\Fixtures\app
 */
class AppKernel extends Kernel
{

    /**
     * Register bundles
     * @return array
     */
    public function registerBundles()
    {
        return array(
            new FindBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_test.yml');
    }

    /**
     * Get cache dir
     * @return string
     */
    public function getCacheDir()
    {
        $cacheDir = sys_get_temp_dir() . '/cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        return $cacheDir;
    }

    /**
     * Get log dir
     * @return string
     */
    public function getLogDir()
    {
        $logDir = sys_get_temp_dir() . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        return $logDir;
    }

}
