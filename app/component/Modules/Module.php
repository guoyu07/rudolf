<?php
namespace Rudolf\Component\Modules;

class Module
{
    public function __construct($name)
    {
        $this->name = $name;
        
        if (empty($name)) {
            throw new \InvalidArgumentException("Invalid module name");
        }
    }

    public function getConfig()
    {
        $file = CONFIG_ROOT . DIRECTORY_SEPARATOR .'modules'. DIRECTORY_SEPARATOR . $this->name .'.php';

        if (!file_exists($file)) {
            throw new \Exception("{$this->name} module configuration does not exist");

        }
        return include $file;
    }
}
