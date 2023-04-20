<?php

abstract class AbstractController
{
    abstract public function route(string $path);

    public function Render(
        string $pagelayout,
        string $template,
        array $params = []
    ) {
        $env = new Environnement('../app/config.php');
        $template = $env->getPathTemplate($template);
        require $env->getPathTemplate($pagelayout);
    }
}
