<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use App\Application\Renderer\PhpTemplateRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use Throwable;

class HttpErrorHandler extends SlimErrorHandler
{
    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        private readonly PhpTemplateRenderer $renderer
    ) {
        parent::__construct($callableResolver, $responseFactory);
    }

    /**
     * @inheritdoc
     */
    protected function respond(): Response
    {
        $exception = $this->exception;
        $statusCode = 500;
        $error = new ActionError(
            ActionError::SERVER_ERROR,
            'An internal error has occurred while processing your request.'
        );

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $error->setDescription($exception->getMessage());

            if ($exception instanceof HttpNotFoundException) {
                $error->setType(ActionError::RESOURCE_NOT_FOUND);
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $error->setType(ActionError::NOT_ALLOWED);
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $error->setType(ActionError::UNAUTHENTICATED);
            } elseif ($exception instanceof HttpForbiddenException) {
                $error->setType(ActionError::INSUFFICIENT_PRIVILEGES);
            } elseif ($exception instanceof HttpBadRequestException) {
                $error->setType(ActionError::BAD_REQUEST);
            } elseif ($exception instanceof HttpNotImplementedException) {
                $error->setType(ActionError::NOT_IMPLEMENTED);
            }
        }

        if (
            !($exception instanceof HttpException)
            && $exception instanceof Throwable
            && $this->displayErrorDetails
        ) {
            $error->setDescription($exception->getMessage());
        }

        $acceptHeader = $this->request ? $this->request->getHeaderLine('Accept') : '';

        if (str_contains($acceptHeader, 'application/json')) {
            $payload = new ActionPayload($statusCode, null, $error);
            $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

            $response = $this->responseFactory->createResponse($statusCode);
            $response->getBody()->write($encodedPayload);

            return $response->withHeader('Content-Type', 'application/json');
        }

        $response = $this->responseFactory->createResponse($statusCode);
        $template = $this->resolveTemplate($statusCode);

        $fallbackMessage = $statusCode === 404
            ? 'Pagina solicitată nu există.'
            : 'A apărut o eroare neașteptată. Te rugăm să încerci mai târziu.';

        $errorMessage = $exception instanceof HttpException && $exception->getMessage() !== ''
            ? $exception->getMessage()
            : $fallbackMessage;

        if (!$this->displayErrorDetails && $statusCode >= 500) {
            $errorMessage = $fallbackMessage;
        }

        return $this->renderer->render($response, $template, [
            'pageTitle' => $this->resolveTitle($statusCode),
            'errorMessage' => $errorMessage,
            'errorDetails' => $this->displayErrorDetails ? (string) $exception : null,
        ]);
    }

    private function resolveTemplate(int $statusCode): string
    {
        return match ($statusCode) {
            403 => 'errors/403',
            404 => 'errors/404',
            default => 'errors/500',
        };
    }

    private function resolveTitle(int $statusCode): string
    {
        return match ($statusCode) {
            403 => 'Acces interzis',
            404 => 'Pagina nu a fost găsită',
            default => 'Eroare internă',
        };
    }
}
