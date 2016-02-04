<?php
/**
 * Class FindExtensionTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Command;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use MauroMoreno\FindBundle\DependencyInjection\FindExtension;

/**
 * Class FindExtensionTest
 * @package MauroMoreno\FindBundle\Tests\Command
 */
class FindExtensionTest extends AbstractExtensionTestCase
{

    /**
     * Get container extension
     * @return array
     */
    protected function getContainerExtensions()
    {
        return [new FindExtension];
    }

    /**
     * Test find_directory_service not defined
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testFindDirectoryServiceNotDefined()
    {
        $this->load([]);
    }

    /**
     * Test finder not defined
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testFinderNotDefined()
    {
        $this->load(['find_directory_service' => '']);
    }

    /**
     * Test lister not defined
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testListerNotDefined()
    {
        $this->load(['find_directory_service' => '', 'finder' => '']);
    }

    /**
     * Test Ok
     */
    public function testOk()
    {
        $this->load(
            ['find_directory_service' => '', 'finder' => '', 'lister' => '']
        );

        $this->assertContainerBuilderHasParameter(
            'mauro_moreno_find.find_directory_service.class',
            'MauroMoreno\FindBundle\Service\FindDirectoryService'
        );
        $this->assertContainerBuilderHasParameter(
            'mauro_moreno_find.finder.class',
            'MauroMoreno\FindBundle\Service\Finder'
        );
        $this->assertContainerBuilderHasParameter(
            'mauro_moreno_find.lister.class',
            'MauroMoreno\FindBundle\Service\Lister'
        );
    }

}