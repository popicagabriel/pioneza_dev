<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Application\Renderer\PhpTemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) use ($app) {
        /** @var PhpTemplateRenderer $renderer */
        $renderer = $app->getContainer()->get(PhpTemplateRenderer::class);

        return $renderer->render($response, 'under-construction', [
            'pageTitle' => 'Pagina în construcție',
        ]);
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->map(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/{path:.+}', function (
        Request $request,
        Response $response
    ) use ($app) {
        /** @var PhpTemplateRenderer $renderer */
        $renderer = $app->getContainer()->get(PhpTemplateRenderer::class);

        $response = $response->withStatus(404);

        return $renderer->render($response, 'errors/404', [
            'pageTitle' => 'Pagina nu a fost găsită',
            'errorMessage' => 'Pagina solicitată nu există.',
        ]);
    });
};
