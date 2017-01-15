<?php

namespace Rudolf\Component\Modules;

use Rudolf\Component\Routing\RouteCollection;

class Routing
{
    private $collection;
    private $modules;

    /**
     * Constructor.
     * 
     * @param array $modules
     * @param RouteCollection
     * @param string $path from-root path to modules directory
     */
    public function __construct(array $modules, RouteCollection $collection, $path = '/modules')
    {
        $this->collection = $collection;
        $this->modules = $modules;
        $this->path = $path;
    }

    /**
     * Add routes to collection.
     * 
     * @return RouteCollection
     */
    public function addRoutes()
    {
        $collection = $this->collection;

        foreach ($this->modules as $key => $value) {
            $file = $this->path.'/'.$value->getName().'/routing.php';

            if (is_file($file)) {
                include $file;
            }
        }

        return $collection;
    }
}
