<?php
/**
 * Class Finder
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Service;

/**
 * Class Finder
 * @package MauroMoreno\FindBundle\Service
 */
class Finder implements FinderInterface
{

    /**
     * Find method
     *
     * @param string $pattern
     * @param \SplFileInfo $fileInfo
     *
     * @return bool|\SplFileInfo
     */
    public function find($pattern, \SplFileInfo $fileInfo)
    {
        if (!is_string($pattern)) {
            throw new \InvalidArgumentException('Pattern should be an string');
        }
        $pattern = $this->createRegExp($pattern);
        $data = fopen($fileInfo->getPathName(), 'r');

        $return = false;

        while ($line = fgets($data, 1024)) {
            if (preg_match($pattern, $line)) {
                $return = $fileInfo;
            }
        }

        return $return;
    }

    /**
     * Create Regular Expression
     *
     * @param string $pattern
     *
     * @return string
     */
    private function createRegExp($pattern)
    {
        $regexp = "/$pattern/";
        return $regexp;
    }

}
