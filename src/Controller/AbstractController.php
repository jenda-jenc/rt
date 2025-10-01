<?php

namespace App\Controller;

class AbstractController
{
    protected function render(string $template, array $params = [], ?string $layout = 'layout.php'): string
    {
        $templateFile = __DIR__ . '/../../templates/' . $template;
        if (!file_exists($templateFile)) {
            throw new \RuntimeException(sprintf('Šablona %s nenalezena', $template));
        }

        extract($params);
        ob_start();
        include $templateFile;
        $content = ob_get_clean();

        if ($layout === null) {
            return $content;
        }

        $layoutFile = __DIR__ . '/../../templates/' . $layout;
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException(sprintf('Layout %s nenalezen', $layout));
        }

        ob_start();
        include $layoutFile;
        return ob_get_clean();
    }
}
