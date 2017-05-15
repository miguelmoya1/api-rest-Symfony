<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\Annotation as JMS;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class categoryController extends ApiBaseController
{
    /**
     * @Route("/category/", name="get_categories")
     * @Method("GET")
     * @ApiDoc(
     *  section="Categories",
     *  resource=true,
     *  statusCodes={
     *         200="Resultado OK",
     *         401="Usuario no autorizado"
     *  },
     *  headers={
     *      {
     *          "required"=true,
     *          "name"="Authorization",
     *          "description"="Bearer {token}"
     *      }
     *  }
     * )
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository(category::class)->findAll();

        return $this->correctAnswer($category, Response::HTTP_OK);
    }
}