<?php


namespace App\V1\Controller;


use Yiisoft\DataResponse\DataResponseFactoryInterface;

class BaseApiController
{
    protected DataResponseFactoryInterface $responseFactory;

    public function __construct(DataResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
}
