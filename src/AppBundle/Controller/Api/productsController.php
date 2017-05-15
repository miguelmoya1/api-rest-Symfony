<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\category;
use AppBundle\Entity\product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\User\User;

class productsController extends ApiBaseController
{
    /**
     * @Route("/products/", name="get_products")
     * @Method("GET")
     * @ApiDoc(
     *  section="Products",
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
    public function getProducts(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

        return $this->correctAnswer($products);
    }

    /**
     * @Route("/products/{id}", name="get_product", requirements={"id": "\d+"})
     * @Method("GET")
     * @ApiDoc(
     *  section="Products",
     *  description="Return a product",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="id of the product to show"
     *      }
     *  },
     *  statusCodes={
     *         200="Resultado OK",
     *         400="Datos no válidos",
     *         404="Tarea no encontrada",
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
    public function getAction($id)
    {
        return $this->getEntity($id, Product::class);
    }

    /**
     * @Route("/products/", name="post_products")
     * @Method("POST")
     * @ApiDoc(
     *  section="Products",
     *  description="Create a new product",
     *  parameters={
     *      {
     *          "name"="title",
     *          "dataType"="string",
     *          "required"=true,
     *      },
     *      {
     *          "name"="description",
     *          "dataType"="string",
     *          "required"=true,
     *      },
     *      {
     *          "name"="status",
     *          "dataType"="integer",
     *          "required"=false,
     *      },
     *      {
     *          "name"="price",
     *          "dataType"="integer",
     *          "required"=true,
     *      },
     *      {
     *          "name"="mainPhoto",
     *          "dataType"="string",
     *          "required"=false,
     *      },
     *      {
     *          "name"="category",
     *          "dataType"="integer",
     *          "required"=true,
     *      }
     *  },
     *  statusCodes={
     *         201="Tarea creada",
     *         400="Datos no válidos",
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
    public function postAction(Request $request)
    {
        $configProduct = function (Product $product) use ($request) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $category = $this->getDoctrine()
                ->getRepository('AppBundle:category')
                ->find(json_decode($request
                    ->getContent())->idCategory);
            $product->setCategory($category);
            $product->setUser($user);
        };

        return $this->postEntity(
            $request, product::class, $configProduct);
    }
}