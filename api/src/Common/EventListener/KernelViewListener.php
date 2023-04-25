<?php

namespace App\Common\EventListener;

use App\Common\Http\Response\HttpOutputInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class KernelViewListener
{
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(ViewEvent $viewEvent): void
    {
        $controllerResult = $viewEvent->getControllerResult();

        if ($controllerResult instanceof HttpOutputInterface) {
            $jsonResponse = $this->serialize($controllerResult);
            $viewEvent->setResponse($jsonResponse);
        }
    }

    public function serialize(HttpOutputInterface $output): JsonResponse
    {
        $data = $this->serializer->serialize($output, 'json', [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['httpStatus'],
        ]);
        return new JsonResponse($data, $output->getHttpStatus(), [], true);
    }
}
