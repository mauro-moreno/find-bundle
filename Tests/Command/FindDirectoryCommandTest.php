<?php
/**
 * Class FindDirectoryCommandTest
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Tests\Command;

use MauroMoreno\FindBundle\Command\FindDirectoryCommand;
use MauroMoreno\FindBundle\Service\FindDirectoryService;
use MauroMoreno\FindBundle\Service\Finder;
use MauroMoreno\FindBundle\Service\Lister;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class FindDirectoryCommandTest
 * @package MauroMoreno\FindBundle\Tests\Command
 */
class FindDirectoryCommandTest extends \PHPUnit_Framework_TestCase
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $application = new Application();
        $application->add(new FindDirectoryCommand());

        $this->command = $application->find('find:dir');
        $this->command->setContainer($this->getMockContainer());
        $this->commandTester = new CommandTester($this->command);
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
     * Test Command execute, empty directory
     */
    public function testExecuteEmptyDirectory()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'pattern' => 'pattern',
            'directory' => __DIR__ . '/empty_directory'
        ]);

        $this->assertEquals(
            "No results where found.\n",
            $this->commandTester->getDisplay()
        );
    }

    /**
     * Test Command execute
     */
    public function testExecute()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'pattern' => 'pattern',
            'directory' => __DIR__ . '/../Fixtures/directory'
        ]);
        $this->assertRegExp(
            '/file_1|file_3/',
            $this->commandTester->getDisplay()
        );
    }

    /**
     * Test Command execute, Extension set
     */
    public function testExecuteExtensionSet()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'pattern' => 'pattern',
            'directory' => __DIR__ . '/../Fixtures/directory',
            '--extension' => 'txt'
        ]);
        $this->assertEquals("file_3.txt\n", $this->commandTester->getDisplay());
    }

    /**
     * Get Mock Container
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockContainer()
    {
        $mockContainer = $this->getMock(
            'Symfony\Component\DependencyInjection\Container'
        );
        $mockContainer
            ->expects($this->once())
            ->method('get')
            ->with('mauro_moreno_find.find_directory_service')
            ->willReturn(new FindDirectoryService(new Finder, new Lister));
        return $mockContainer;
    }

}