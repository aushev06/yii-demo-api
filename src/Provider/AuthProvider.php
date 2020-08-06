<?php


namespace App\Provider;


use Psr\Container\ContainerInterface;
use Yiisoft\Auth\AuthInterface;
use Yiisoft\Auth\IdentityRepositoryInterface;
use Yiisoft\Auth\Method\Composite;
use Yiisoft\Auth\Method\HttpHeader;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;

class AuthProvider extends ServiceProvider
{

    public function register(Container $container): void
    {
        $container->set(
            AuthInterface::class,
            static function (ContainerInterface $container) {
                $userRepository = $container->get(IdentityRepositoryInterface::class);
                $apiAuth = new HttpHeader($userRepository);
                $apiAuth->setPattern("/Bearer\s+(.*)/");
                $apiAuth->setHeaderName('Authorization');

                $authenticator = new Composite($container);
                $authenticator->setAuthMethods(
                    [
                        $apiAuth
                    ]
                );

                return $authenticator;
            }
        );
    }
}
