<?php
/**
 * Class FindDirectoryService
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Service;

/**
 * Class FindDirectoryService
 * @package MauroMoreno\FindBundle\Service
 */
class FindDirectoryService
{

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $extension = "";

    /**
     * @var FinderInterface
     */
    private $finder;

    /**
     * @var ListerInterface
     */
    private $lister;

    /**
     * FindDirectoryService constructor.
     * @param FinderInterface $finder
     * @param ListerInterface $lister
     */
    public function __construct(
        FinderInterface $finder,
        ListerInterface $lister
    ) {
        $this->finder = $finder;
        $this->lister = $lister;
    }

    /**
     * FindDirectory find
     * @return array|bool
     */
    public function find()
    {
        if ($this->getPattern() === '') {
            throw new \InvalidArgumentException('Pattern cannot be empty.');
        }

        if (empty($this->getDirectory())) {
            throw new \InvalidArgumentException(
                'The target directory cannot be empty.'
            );
        }

        if (!is_dir($this->getDirectory())) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The target directory "%s" does not exist.',
                    $this->getDirectory()
                )
            );
        }

        $return = false;

        $file_iterator = $this->lister->ls(
            $this->getDirectory(),
            $this->getExtension()
        );
        $count = count(iterator_to_array($file_iterator));

        if ($count > 0) {
            $return = [];
            foreach ($file_iterator as $file) {
                $found = $this->finder->find($this->getPattern(), $file);
                if ($found !== false) {
                    $return[] = [
                        'filename' => $found->getFilename(),
                        'pathname' => $found->getPathName()
                    ];;
                }
            }
        }

        return $return;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

}
