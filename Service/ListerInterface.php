<?php
/**
 * Interface ListerInterface
 *
 * @author Mauro Moreno <moreno.mauro.emanuel@gmail.com>
 */
namespace MauroMoreno\FindBundle\Service;

/**
 * Interface ListerInterface
 * @package MauroMoreno\FindBundle\Service
 */
interface ListerInterface
{

    /**
     * ls method should be implemented
     *
     * @param string $directory
     * @param string $extension
     *
     * @return \Iterator
     */
    public function ls($directory, $extension = '');

}
