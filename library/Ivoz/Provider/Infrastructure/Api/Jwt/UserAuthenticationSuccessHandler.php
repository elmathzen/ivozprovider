<?php

namespace Ivoz\Provider\Infrastructure\Api\Jwt;

use Ivoz\Provider\Domain\Model\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

/** @psalm-suppress InvalidExtendClass */
class UserAuthenticationSuccessHandler extends AuthenticationSuccessHandler
{
    /**
     * @inheritdoc
     */
    public function handleAuthenticationSuccess(SymfonyUserInterface $user, $jwt = null)
    {
        $this->jwtManager->setUserIdentityField('email');

        // Check if user has 2FA enabled
        if ($user instanceof UserInterface && $user->getTwoFactorEnabled()) {
            // Create a temporary token with limited claims
            $tempToken = $this->jwtManager->create($user);
            
            // Return a response indicating 2FA is required
            return new JsonResponse([
                'twoFactorRequired' => true,
                'tempToken' => $tempToken
            ]);
        }

        return parent::handleAuthenticationSuccess(...func_get_args());
    }
}
