<?php


namespace App\V1\Post;


use App\V1\Controller\BaseApiController;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class PostController extends BaseApiController
{
    public function index(): ResponseInterface
    {
        return $this->responseFactory->createResponse(['user' => 123]);
    }
}
