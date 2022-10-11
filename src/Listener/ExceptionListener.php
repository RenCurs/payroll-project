<?php

namespace App\Listener;

use App\Exception\ValidationException;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

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

        if ($exception instanceof ValidationException) {
            $errors = $exception->errors;
            $message = sprintf(
                'Message: %s, errors: %s',
                $exception->getMessage(),
                json_encode($exception->errors, JSON_THROW_ON_ERROR)
            );
        } else {
            $message = $exception->getMessage();
            $errors = [$this->translator->trans('error.default_message')];
        }

        $this->logger->error($message);

        $response = new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        $event->setResponse($response);
    }
}
