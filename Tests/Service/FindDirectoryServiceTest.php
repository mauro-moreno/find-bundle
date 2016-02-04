<?php
/**
 * Class FindServiceTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Services;

use MauroMoreno\FindBundle\Service\FindDirectoryService;
use MauroMoreno\FindBundle\Service\FinderInterface;
use MauroMoreno\FindBundle\Service\ListerInterface;

/**
 * Class FindServiceTest
 * @package MauroMoreno\FindBundle\Tests\FindService
 */
class FindDirectoryServiceTest extends \PHPUnit_Framework_TestCase
{

    private $finder_mock;

    private $lister_mock;

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
     * Test find empty pattern
     */
    public function testFindEmptyPatternArgument()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Pattern cannot be empty.'
        );

        $this->setPatternAndDirectory("")->find();
    }

    /**
     * Test find empty directory
     */
    public function testFindEmptyDirectoryArgument()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'The target directory cannot be empty.'
        );

        $this->setPatternAndDirectory('pattern', '')->find();
    }

    /**
     * Test find wrong directory
     */
    public function testFindWrongDirectory()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'The target directory "' . __DIR__ . '/not_directory" does not exist.'
        );
        $this->setPatternAndDirectory('pattern', '/not_directory')->find();
    }

    /**
     * Test find empty directory
     */
    public function testFindEmptyDirectory()
    {
        $find_directory_service = $this->setPatternAndDirectory(
            'pattern',
            '/empty_directory'
        );
        $this->lister_mock->expects($this->once())
            ->method('ls')
            ->will($this->returnValue(new \GlobIterator(
                __DIR__ . '/empty_directory/*'
            )));

        $found = $find_directory_service->find();

        $this->assertEquals('pattern', $find_directory_service->getPattern());
        $this->assertEquals(
            __DIR__ . '/empty_directory',
            $find_directory_service->getDirectory()
        );

        $this->assertFalse($found);
    }

    /**
     * Test find empty result
     */
    public function testFindEmptyResult()
    {
        $find_directory_service = $this->setPatternAndDirectory('bad');
        $this->lister_mock->expects($this->once())
            ->method('ls')
            ->will($this->returnValue(new \GlobIterator(
                __DIR__ . '/../Fixtures/directory/*'
            )));
        $this->finder_mock->expects($this->exactly(4))
            ->method('find')
            ->will($this->returnValue(false));

        $found = $find_directory_service->find();

        $this->assertEquals(0, count($found));
    }

    /**
     * Test find result
     */
    public function testFindResult()
    {
        $find_directory_service = $this->setPatternAndDirectory();
        $this->lister_mock->expects($this->once())
            ->method('ls')
            ->will($this->returnValue(new \GlobIterator(
                __DIR__ . '/../Fixtures/directory/*'
            )));
        $this->finder_mock->expects($this->at(0))
            ->method('find')
            ->will($this->returnValue(new \SplFileInfo(
                __DIR__ . '/../Fixtures/directory/file_1'
            )));
        $this->finder_mock->expects($this->at(1))
            ->method('find')
            ->will($this->returnValue(false));
        $this->finder_mock->expects($this->at(2))
            ->method('find')
            ->will($this->returnValue(new \SplFileInfo(
                __DIR__ . '/../Fixtures/directory/file_1.txt'
            )));
        $this->finder_mock->expects($this->at(3))
            ->method('find')
            ->will($this->returnValue(false));

        $found = $find_directory_service->find();

        $this->assertEquals(2, count($found));
        $this->assertEquals('file_1', $found[0]['filename']);
        $this->assertEquals(
            __DIR__ . '/../Fixtures/directory/file_1',
            $found[0]['pathname']
        );
    }

    /**
     * Test find empty result, extension set
     */
    public function testFindEmptyResultExtensionSet()
    {
        $find_directory_service = $this->setPatternAndDirectory(
            'bad',
            '/../Fixtures/directory',
            'txt'
        );
        $this->lister_mock->expects($this->once())
            ->method('ls')
            ->will($this->returnValue(new \GlobIterator(
                __DIR__ . '/../Fixtures/directory/*.txt'
            )));
        $this->finder_mock->expects($this->exactly(2))
            ->method('find')
            ->will($this->returnValue(false));

        $found = $find_directory_service->find();

        $this->assertEquals(0, count($found));
    }

    /**
     * Test find result, extension set
     */
    public function testFindResultExtensionSet()
    {
        $find_directory_service = $this->setPatternAndDirectory(
            'pattern',
            '/../Fixtures/directory',
            'txt'
        );
        $this->lister_mock->expects($this->once())
            ->method('ls')
            ->will($this->returnValue(new \GlobIterator(
                __DIR__ . '/../Fixtures/directory/*.txt'
            )));
        $this->finder_mock->expects($this->at(0))
            ->method('find')
            ->will($this->returnValue(new \SplFileInfo(
                __DIR__ . '/../Fixtures/directory/file_3.txt'
            )));
        $this->finder_mock->expects($this->at(1))
            ->method('find')
            ->will($this->returnValue(false));

        $found = $find_directory_service->find();

        $this->assertEquals('file_3.txt', $found[0]['filename']);
        $this->assertEquals(
            __DIR__ . '/../Fixtures/directory/file_3.txt',
            $found[0]['pathname']
        );
    }

    /**
     * Get FindDirectoryService instance
     * @return FindDirectoryService
     */
    private function getFindDirectoryService()
    {
        // Mock Finder.
        $mock_builder = $this->getMockBuilder(FinderInterface::class);
        $mock_builder->setMethods(['find']);
        $this->finder_mock = $mock_builder->getMock();

        // Mock Lister.
        $mock_builder = $this->getMockBuilder(ListerInterface::class);
        $mock_builder->setMethods(['ls']);
        $this->lister_mock = $mock_builder->getMock();

        // Return service with mocked interfaces.
        return new FindDirectoryService(
            $this->finder_mock,
            $this->lister_mock
        );
    }

    /**
     * Set Pattern and Directory to FindDirectoryService
     * @param string $pattern
     * @param string $directory
     * @param string $extension
     * @return FindDirectoryService
     */
    private function setPatternAndDirectory(
        $pattern = 'pattern',
        $directory = '/../Fixtures/directory',
        $extension = null
    ) {
        $find_directory_service = $this->getFindDirectoryService()
            ->setPattern($pattern)
            ->setDirectory(
                (!empty($directory) ? __DIR__ . $directory : $directory)
            );
        if (!empty($extension)) {
            $find_directory_service->setExtension($extension);
        }
        return $find_directory_service;
    }

}
