<?php

namespace views;

class View
{
    public string $bodyTemplate, $title, $lang;

    public array $scripts, $styles;

    public function __construct(string $bodyTemplate, string $title, array $scripts = [], array $styles = [], string $lang = 'ru')
    {
        $this->bodyTemplate = $bodyTemplate;
        $this->title = $title;
        $this->scripts = $scripts;
        $this->styles = $styles;
        $this->lang = $lang;
    }

    public function renderHTML(array $vars = [])
    {
        $body = $this->getHTML($this->bodyTemplate, $vars);
        echo $this->getHTML('general.php', ['body' => $body]);
    }

    public function getHTML(string $templateName, array $vars) : string
    {

        $route = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $templateName;

        if (file_exists($route)) {
            extract($vars);
            ob_start();
            include $route;
            $buffer = ob_get_contents();
            ob_end_clean();

            return $buffer;
        }

        return 'Set correct body template';
    }
}