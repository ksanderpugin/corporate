<?php

namespace views;

class View
{
    private string $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }

    public function main()
    {
        $this->renderHTML('main.php');
    }

    public function renderHTML(string $templateName, array $vars = [])
    {
        echo $this->getHTML($templateName, $vars);
    }

    public function getHTML(string $templateName, array $vars) : string
    {

        $route = $this->templatesPath . DIRECTORY_SEPARATOR . $templateName;

        if (file_exists($route)) {
            extract($vars);
            ob_start();
            include $route;
            $buffer = ob_get_contents();
            ob_end_clean();

            return $buffer;
        }

        return "";
    }
}