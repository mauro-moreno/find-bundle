<?php
/**
 * Class ConfigurationTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Command;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use MauroMoreno\FindBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class ConfigurationTest
 * @package MauroMoreno\FindBundle\Tests\Command
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Use Trait for Configuration testing
     */
    use ConfigurationTestCaseTrait;

    /**
     * @return ConfigurationInterface
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * Test find_directory_service not defined
     */
    public function testFindDirectoryServiceNotDefined()
    {
        $this->assertConfigurationIsInvalid(
            [
                []
            ],
            'find_directory_service'
        );
    }

    /**
     * Test finder not defined
     */
    public function testFinderNotDefined()
    {
        $this->assertConfigurationIsInvalid(
            [
                ['find_directory_service' => '']
            ],
            'finder'
        );
    }

    /**
     * Test lister not defined
     */
    public function testListerNotDefined()
    {
        $this->assertConfigurationIsInvalid(
            [
                ['find_directory_service' => ''],
                ['finder' => '']
            ],
            'lister'
        );
    }

    /**
     * Test Ok
     */
    public function testOk()
    {
        $this->assertConfigurationIsValid(
            [
                ['find_directory_service' => ''],
                ['finder' => ''],
                ['lister' => ''],
            ]
        );
    }

}
