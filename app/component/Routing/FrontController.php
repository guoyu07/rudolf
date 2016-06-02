<?php
namespace Rudolf\Component\Routing;

use Rudolf\Component\Http\HttpErrorException;

class FrontController
{
    /**
     * @var Router object
     */
    private $router;

    /**
     * @var string Controller name
     */
    private $controller;

    /**
     * @var string Method name
     */
    private $method;

    /**
     * @var array Params array
     */
    private $params;

    /**
     * Constructor
     * 
     * @param Router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Run
     * 
     * @return void
     */
    public function run()
    {
        if (false === $this->router->run()) {
            throw new HttpErrorException('No routing rules (error 404)', 404);
        }

        $names = $this->explodeName($this->router->getControllerName());

        if (!class_exists($names[0])) {
            throw new HttpErrorException('Controller class '. $names[0].' doesn\'t exist');
        }

        $this->call($names, $this->router->getParams());
    }

    /**
     * Call controller method
     * 
     * @param object @object
     * @param string $method
     * @param array $params
     * 
     * @return bool
     */
    private function call($class, $params)
    {
        $object = new $class[0]();

        if (false === isset($class[1])) {
            $method = 'index';
        } else {
            $method = $class[1];
        }

        return call_user_func_array(array($object, $method), $params);
    }

    /**
     * Divides the the name of the class and method
     * 
     * @param string $name
     * 
     * @return array|bool
     */
    private function explodeName($name)
    {
        $array = explode('::', $name);

        if (!empty($array)) {
            return $array; 
        }

        return false;
    }
}
