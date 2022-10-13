<?php

namespace App\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthFailureListener
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TranslatorInterface $translator
    ) {}

    public function onLoginFailure(LoginFailureEvent $event): void
    {
        $this->logger->error(sprintf('[Auth] Login error: %s', $event->getException()->getMessage()));
        $error = $event->getException() instanceof BadCredentialsException
            ? $this->translator->trans('error.auth')
            : $event->getException()->getMessage();

        $response = new JsonResponse(['errors' => [$error]]);


        $event->setResponse($response);
        $event->stopPropagation();
    }
}
