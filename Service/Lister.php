<?php
/**
 * Class Lister
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Service;

/**
 * Class Lister
 * @package MauroMoreno\FindBundle\Service
 */
class Lister implements ListerInterface
{

    /**
     * List method
     *
     * @param string $directory
     * @param string $extension
     *
     * @return \GlobIterator
     */
    public function ls($directory, $extension = '')
    {
        if (!is_string($directory)) {
            throw new \InvalidArgumentException(
                'Directory should be an string.'
            );
        }
        if (!is_dir($directory)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The target directory "%s" does not exist.',
                    $directory
                )
            );
        }
        $path = $this->createPath($directory, $extension);
        return new \GlobIterator($path);
    }

    /**
     * Create path
     *
     * @param $directory
     * @param $extension
     *
     * @return string
     */
    private function createPath($directory, $extension = '')
    {
        $path = $directory;
        $path .= '/*';
        if ($extension !== "" && $extension) {
            $path .= '.' . $extension;
        }
        return $path;
    }

}
