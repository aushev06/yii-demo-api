<?php

namespace App\Factory;

use App\Blog\Archive\ArchiveController;
use App\Blog\BlogController;
use App\Blog\CommentController;
use App\Blog\Post\PostController;
use App\Blog\Tag\TagController;
use App\Contact\ContactController;
use App\Controller\ApiInfo;
use App\Controller\ApiUserController;
use App\Controller\AuthController;
use App\Controller\SignupController;
use App\Controller\SiteController;
use App\Controller\UserController;
use App\Middleware\ApiDataWrapper;
use Psr\Container\ContainerInterface;
use Yiisoft\Http\Method;
use Yiisoft\Router\FastRoute\UrlMatcher;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Yiisoft\Router\RouteCollection;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\DataResponse\Middleware\FormatDataResponse;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsJson;
use Yiisoft\DataResponse\Middleware\FormatDataResponseAsXml;

class AppRouterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $routes = [
            // Lonely pages of site
            Group::create('/v1', [
                Route::post('/user', [ApiUserController::class, 'signUp'])
                    ->addMiddleware(fn() => new \Tuupola\Middleware\CorsMiddleware([
                        "origin"         => ["*"],
                        "methods"        => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                        "headers.allow"  => [],
                        "headers.expose" => [],
                        "credentials"    => true,
                        "cache"          => 0,
                    ]))
                    ->addMiddleware(FormatDataResponseAsJson::class)
                    ->name('v1/api/user/create')
            ])
                ->addMiddleware(ApiDataWrapper::class),
        ];

        $collector = $container->get(RouteCollectorInterface::class);
        $collector->addGroup(
            Group::create(null, $routes)
                ->addMiddleware(FormatDataResponse::class)
        );

        return new UrlMatcher(new RouteCollection($collector));
    }
}
