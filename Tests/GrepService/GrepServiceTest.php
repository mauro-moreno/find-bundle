<?php
/**
 * Class GrepServiceTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\GrepBundle\Tests\GrepService;

use MauroMoreno\GrepBundle\Tests\Fixtures\app\AppKernel;
use MauroMoreno\GrepBundle\Service\GrepService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GrepServiceTest
 * @package MauroMoreno\GrepBundle\Tests\GrepService
 */
class GrepServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = new AppKernel(getenv('ENV'), getenv('DEBUG') === 'true');
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    /**
     * Test if service is defined in container.
     */
    public function testServiceIsDefinedInContainer()
    {
        $service = $this->container->get(
            'mauro_moreno_grep.grep_service'
        );

        $this->assertInstanceOf(GrepService::class, $service);
    }

}
