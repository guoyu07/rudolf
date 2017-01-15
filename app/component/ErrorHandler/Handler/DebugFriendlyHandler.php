<?php

namespace Rudolf\Component\ErrorHandler\Handler;

class DebugFriendlyHandler extends Handler implements IHandler
{
    public function handle()
    {
        $this->pageTitle = 'Oh no! Error occurred!';
        $this->pageStyle = $this->getResource(['css/reset.css', 'css/style.css']);
        $this->pageScript = $this->getResource(['js/checkargs.js']);
        $this->message = $this->getException()->getMessage();
        $this->description = $this->getDescription();
        $this->trace = $this->getTrace();

        echo $this->getResource('templates/layout.html.php', true);
    }

    /**
     * Get resource.
     *
     * @param string|array $name
     * @param bool         $include
     *
     * @return string
     */
    private function getResource($name, $include = false)
    {
        if (true === $include) {
            ob_start();
            include __DIR__.'/../Resources/'.$name;

            return ob_get_clean();
        }

        foreach ($name as $key => $value) {
            $t[] = file_get_contents(__DIR__.'/../Resources/'.$value);
        }

        return implode('', $t);
    }
}
