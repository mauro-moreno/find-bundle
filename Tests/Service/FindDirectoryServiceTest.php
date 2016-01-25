<?php
/**
 * Class FindServiceTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\FindServices;

use MauroMoreno\FindBundle\Tests\Fixtures\app\AppKernel;
use MauroMoreno\FindBundle\Service\FindDirectoryService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FindServiceTest
 * @package MauroMoreno\FindBundle\Tests\FindService
 */
class FindDirectoryServiceTest extends \PHPUnit_Framework_TestCase
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
        mkdir(__DIR__ . '/empty_directory');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        rmdir(__DIR__ . '/empty_directory');
        parent::tearDown();
    }

    /**
     * Test if service is defined in container.
     */
    public function testServiceIsDefinedInContainer()
    {
        $service = $this->container->get(
            'mauro_moreno_find.find_directory_service'
        );

        $this->assertInstanceOf(FindDirectoryService::class, $service);
    }

    /**
     * Test find empty pattern
     */
    public function testFindEmptyPattern()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Pattern cannot be empty.'
        );
        $this->getFindDirectoryService()->find('', __DIR__ . '/directory');
    }

    /**
     * Test find empty directory
     */
    public function testFindEmptyDir()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'The target directory cannot be empty.'
        );
        $this->getFindDirectoryService()->find('pattern', '');
    }

    /**
     * Test find wrong directory
     */
    public function testFindWrongDirectory()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'The target directory "not_directory" does not exist.'
        );
        $this->getFindDirectoryService()->find('pattern', 'not_directory');
    }

    /**
     * Test find empty directory
     */
    public function testFindEmptyDirectory()
    {
        $find_directory_service = $this->getFindDirectoryService();
        $found = $find_directory_service->find(
            'pattern',
            __DIR__ . '/empty_directory'
        );

        $this->assertEquals('/pattern/', $find_directory_service->getPattern());
        $this->assertEquals(
            __DIR__ . '/empty_directory',
            $find_directory_service->getDirectory()
        );

        $file_iterator = $find_directory_service->getFileIterator();
        $this->assertInstanceOf(
            \GlobIterator::class,
            $file_iterator
        );

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $this->assertEquals(0, $file_iterator->count());
        $this->assertEquals(0, count(iterator_to_array($file_iterator)));

        $this->assertFalse($found);
    }

    /**
     * Test find empty result
     */
    public function testFindEmptyResult()
    {
        $find_directory_service = $this->getFindDirectoryService();
        $found = $find_directory_service->find(
            'bad',
            __DIR__ . '/../Fixtures/directory'
        );

        $file_iterator = $find_directory_service->getFileIterator();
        $this->assertInstanceOf(
            \GlobIterator::class,
            $file_iterator
        );

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $this->assertEquals(0, $file_iterator->count());
        $this->assertEquals(4, count(iterator_to_array($file_iterator)));
        $this->assertEquals(0, count($found));
    }

    /**
     * Test find result
     */
    public function testFindResult()
    {
        $find_directory_service = $this->getFindDirectoryService();
        $found = $find_directory_service->find(
            'pattern',
            __DIR__ . '/../Fixtures/directory'
        );

        $file_iterator = $find_directory_service->getFileIterator();
        $this->assertInstanceOf(
            \GlobIterator::class,
            $file_iterator
        );

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $this->assertEquals(0, $file_iterator->count());
        $this->assertEquals(4, count(iterator_to_array($file_iterator)));
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
        $find_directory_service = $this->getFindDirectoryService();
        $found = $find_directory_service->find(
            'bad',
            __DIR__ . '/../Fixtures/directory',
            'txt'
        );

        $file_iterator = $find_directory_service->getFileIterator();
        $this->assertInstanceOf(
            \GlobIterator::class,
            $file_iterator
        );

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $this->assertEquals(0, $file_iterator->count());
        $this->assertEquals(2, count(iterator_to_array($file_iterator)));
        $this->assertEquals(0, count($found));
    }

    /**
     * Test find result, extension set
     */
    public function testFindResultExtensionSet()
    {
        $find_directory_service = $this->getFindDirectoryService();
        $found = $find_directory_service->find(
            'pattern',
            __DIR__ . '/../Fixtures/directory',
            'txt'
        );

        $file_iterator = $find_directory_service->getFileIterator();
        $this->assertInstanceOf(
            \GlobIterator::class,
            $file_iterator
        );

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $this->assertEquals(0, $file_iterator->count());
        $this->assertEquals(2, count(iterator_to_array($file_iterator)));
        $this->assertEquals(1, count($found));
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
        return new FindDirectoryService();
    }

}
