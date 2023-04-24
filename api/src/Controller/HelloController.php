<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route(path="/api/hello")
     */
    public function hello(): Response
    {
        return $this->json([
            'hello' => 'world'
        ]);
    }
}
