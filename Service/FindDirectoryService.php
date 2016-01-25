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
     * @var \GlobIterator
     */
    private $file_iterator;

    /**
     * @var string
     */
    private $extension = "";

    /**
     * FindDirectory find
     * @param $pattern
     * @param $directory
     * @param string $extension
     * @return array|bool
     */
    public function find($pattern, $directory, $extension = "", $line = false)
    {
        if (empty($pattern)) {
            throw new \InvalidArgumentException('Pattern cannot be empty.');
        }

        if (empty($directory)) {
            throw new \InvalidArgumentException(
                'The target directory cannot be empty.'
            );
        }

        if (!is_dir($directory)) {
            throw new \InvalidArgumentException(
                sprintf('The target directory "%s" does not exist.', $directory)
            );
        }

        $return = false;

        $this->setPattern($pattern);
        $this->setDirectory($directory);

        if (!empty($extension)) {
            $this->setExtension($extension);
        }

        $path = $this->createPath();
        $this->setFileIterator(new \GlobIterator($path));

        // TODO: Fix when bug is fixed https://bugs.php.net/bug.php?id=55701
        // $count = $this->getFileIterator()->count();
        $count = count(iterator_to_array($this->getFileIterator()));

        if ($count > 0) {
            $return = [];
            foreach ($this->getFileIterator() as $file) {
                $data = file_get_contents($file->getPathName());
                preg_match_all(
                    $this->getPattern(),
                    $data,
                    $matches,
                    PREG_OFFSET_CAPTURE
                );

                if (count($matches[0]) > 0) {
                    $return[] = [
                        'filename' => $file->getFilename(),
                        'pathname' => $file->getPathName()
                    ];
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
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $this->createRegExp($pattern);
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param string $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @return \GlobIterator
     */
    public function getFileIterator()
    {
        return $this->file_iterator;
    }

    /**
     * @param \GlobIterator $file_iterator
     */
    public function setFileIterator($file_iterator)
    {
        $this->file_iterator = $file_iterator;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Create Regular Expresion
     * @param $pattern
     * @return string
     */
    private function createRegExp($pattern)
    {
        $regexp = "/$pattern/";
        return $regexp;
    }

    /**
     * Create Path
     * @return string
     */
    private function createPath()
    {
        $path = $this->getDirectory();
        $path .= '/*';
        if ($this->getExtension() !== "") {
            $path .= '.' . $this->getExtension();
        }
        return $path;
    }

}
