<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\Api\ApiBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AuthController extends ApiBaseController
{
    /**
     * @Route("/auth/login")
     * @Method("POST")
     * @ApiDoc(
     *  section="Tokens",
     *  description="Obtiene un token de seguridad a partir de un usuario y un password. Los parámetros email y password se pasan por POST.",
     *  parameters={
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="email de usuario"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "required"=true,
     *          "description"="Password del usuario"
     *      }
     *  },
     *  statusCodes={
     *         200="Token Creado OK",
     *         401="Usuario no autorizado"
     *  }
     * )
     */
    public function getTokenAction()
    {
        return $this->correctAnswer("", Response::HTTP_UNAUTHORIZED);
        // return new Response('', Response::HTTP_UNAUTHORIZED);
    }
}