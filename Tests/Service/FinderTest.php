<?php
/**
 * Class FinderTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Services;

use MauroMoreno\FindBundle\Service\Finder;

/**
 * Class FinderTest
 * @package MauroMoreno\FindBundle\Tests\Services
 */
class FinderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Finder
     */
    private $finder;

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->finder = new Finder();
    }

    /**
     * Test find, wrong parameter pattern
     *
     * @expectedException \InvalidArgumentException
     */
    public function testFindWrongParameterPattern()
    {
        $found = $this->finder->find(
           [],
            new \SplFileInfo(__DIR__ . '/../Fixtures/directory/file_2')
        );
    }

    /**
     * Test find, wrong parameter fileInfo
     *
     * @expectedException \TypeError
     */
    public function testFindWrongParameterFileInfo()
    {
        $found = $this->finder->find(
            'pattern',
            'bad_parameter'
        );
    }

    /**
     * Test find, not found
     */
    public function testFindNotFound()
    {
        $found = $this->finder->find(
            'pattern',
            new \SplFileInfo(__DIR__ . '/../Fixtures/directory/file_2')
        );

        $this->assertEquals($found, false);
    }

    /**
     * Test find Ok
     */
    public function testFindOk()
    {
        $file_info = new \SplFileInfo(
            __DIR__ . '/../Fixtures/directory/file_1'
        );
        $found = $this->finder->find(
            'pattern',
            $file_info
        );

        $this->assertEquals($found, $file_info);
    }

}