<?php

namespace App\Listener;

use App\Exception\ValidationException;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

class ExceptionListener
{
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly LoggerInterface $logger
    ) {}

    /**
     * @throws JsonException
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        [$errors, $responseCode] = $this->getExceptionData($exception);
        $message = sprintf(
            'Message: %s, errors: %s',
            $exception->getMessage(),
            json_encode($errors, JSON_THROW_ON_ERROR)
        );

        $this->logger->error($message);

        // TODO Добавить класс ответа ?
        $response = new JsonResponse(['errors' => $errors], $responseCode);
        $event->setResponse($response);
    }

    private function isAuthException(Throwable $exception): bool
    {
        return $exception instanceof HttpExceptionInterface
            && in_array($exception->getStatusCode(), [Response::HTTP_UNAUTHORIZED, Response::HTTP_FORBIDDEN], true);
    }

    /**
     * @return array<int, array<string[], int>>
     */
    private function getExceptionData(Throwable $exception): array
    {
        $code = Response::HTTP_BAD_REQUEST;

        if ($exception instanceof ValidationException) {
            $errors = $exception->errors;
        } else if ($this->isAuthException($exception)) {
            $errors = [$this->translator->trans('error.auth')];
            /** @var HttpExceptionInterface $exception */
            $code = $exception->getStatusCode();
        }
        else {
            $errors = [$this->translator->trans('error.default_message')];
        }

        return [$errors, $code];
    }
}
