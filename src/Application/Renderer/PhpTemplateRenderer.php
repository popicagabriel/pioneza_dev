<?php

declare(strict_types=1);

namespace App\Application\Renderer;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class PhpTemplateRenderer
{
    private string $templatesPath;

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = rtrim($templatesPath, DIRECTORY_SEPARATOR);
    }

    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        $templateFile = $this->templatesPath . DIRECTORY_SEPARATOR . $template . '.php';

        if (!is_file($templateFile)) {
            throw new RuntimeException(sprintf('Template "%s" not found.', $template));
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $templateFile;
        $content = ob_get_clean();

        $response->getBody()->write($content);

        return $response->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}

