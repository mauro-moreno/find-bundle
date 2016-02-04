<?php
/**
 * Interface FinderInterface
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Service;

/**
 * Interface FinderInterface
 * @package MauroMoreno\FindBundle\Service
 */
interface FinderInterface
{

    /**
     * find method should be implemented
     *
     * @param string $pattern
     * @param \SplFileInfo $fileInfo
     *
     * @return bool|\SplFileInfo
     */
    public function find($pattern, \SplFileInfo $fileInfo);

}
