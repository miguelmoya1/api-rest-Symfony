<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends ApiBaseController
{
    /**
     * @Route("/auth/login")
     */
    public function getTokenAction()
    {
        // The security layer will intercept this request
        return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}