<?php
/**
 * Class ListerTest
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Services;

use MauroMoreno\FindBundle\Service\Lister;

/**
 * Class ListerTest
 * @package MauroMoreno\FindBundle\Tests\Services
 */
class ListerTest extends \PHPUnit_Framework_TestCase
{

    private $lister;

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->lister = new Lister();
    }

    /**
     * @beforeClass
     */
    public static function setUpBeforeClass()
    {
        if (!is_dir(__DIR__ . '/empty_directory')) {
            mkdir(__DIR__ . '/empty_directory');
        }
    }

    /**
     * @afterClass
     */
    public static function tearDownAfterClass()
    {
        if (is_dir(__DIR__ . '/empty_directory')) {
            rmdir(__DIR__ . '/empty_directory');
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLsWrongParameterDirectory()
    {
        $this->lister->ls([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLsWrongParameterDirectoryNonExistent()
    {
        $this->lister->ls('not_directory');
    }

    public function testLsWrongParameterDirectoryEmptyDirectory()
    {
        $list = $this->lister->ls(__DIR__ . '/empty_directory');

        $this->assertEquals(0, count(iterator_to_array($list)));
    }

}