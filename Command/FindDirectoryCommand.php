<?php
/**
 * Class FindDirectoryCommand
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FindDirectoryCommand
 * @package MauroMoreno\FindBundle\Command
 */
class FindDirectoryCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('find:dir')
            ->setDescription('Find files that contains a pattern')
            ->addArgument(
                'pattern',
                InputArgument::REQUIRED,
                'Pattern is, by default, a basic regular expression.'
            )->addArgument(
                'directory',
                InputArgument::REQUIRED,
                'Directory path.'
            )->addOption(
                'extension',
                'e',
                InputOption::VALUE_NONE,
                'File extension.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $this->getContainer()
            ->get('mauro_moreno_find.find_directory_service')
            ->setPattern($input->getArgument('pattern'))
            ->setDirectory($input->getArgument('directory'))
            ->setExtension($input->getOption('extension'))
            ->find();

        if ($files) {
            foreach($files as $file) {
                $output->writeln($file['filename']);
            }
        } else {
            $output->writeln('No results where found.');
        }
    }

}