<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiBaseController
{
    /**
     * @Route("/api/tokens")
     */
    public function getTokenAction()
    {
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}