<?php

namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class ApiBaseController extends Controller
{
    /**
     * @param $data
     * @param Response $response
     * @param $arrSerializationGroups
     */
    private function setContent($data, Response $response, $arrSerializationGroups)
    {
        if (!is_null($data))
        {
            $result['data'] = $data;

            $serializedData = $this->get('jms_serializer')->serialize(
                $result,
                "json",
                SerializationContext::create()->setGroups($arrSerializationGroups));

            $response->setContent($serializedData);
        }
    }

    /**
     * @param $data
     * @param int $statusCode
     * @param array $arrSerializationGroups
     * @return Response
     */
    protected function correctAnswer($data, $statusCode = Response::HTTP_OK, $arrSerializationGroups=array('Default'))
    {
        $response = new Response();

        $this->setContent($data, $response, $arrSerializationGroups);

        $response->setStatusCode($statusCode);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @return Response
     */
    protected function answerNotFound()
    {
        return $this->correctAnswer(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return Response
     */
    protected function unauthorizedUser()
    {
        return $this->correctAnswer(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param $data
     * @param array $arrSerializationGroups
     * @return Response
     */
    protected function incorrectData($data, $arrSerializationGroups=array('Default'))
    {
        return $this->correctAnswer($data, Response::HTTP_BAD_REQUEST, $arrSerializationGroups);
    }

    /**
     * @param $entity
     * @param array $arrSerializationGroups
     * @return Response
     */
    protected function saveValidating($entity, $arrSerializationGroups=array('Default'))
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($entity);

        if (count($errors) > 0)
        {
            $errorsMessages = array();
            foreach($errors as $error)
                $errorsMessages[] = $error->getMessage();

            return $this->incorrectData($errorsMessages, $arrSerializationGroups);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return $this->correctAnswer($entity, Response::HTTP_CREATED, $arrSerializationGroups);
        }
    }

    /**
     * @param $id
     * @param $entityName
     * @return mixed
     */
    protected function deleteEntity($id, $entityName)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository($entityName)->find($id);

        if (is_null($entity) === true)
            return $this->answerNotFound();

        $em->remove($entity);
        $em->flush();

        return $this->correctAnswer(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $id
     * @param $entityName
     * @param array $arrSerializationGroups
     * @return mixed
     */
    protected function getEntity($id, $entityName, $arrSerializationGroups=array('Default'))
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository($entityName)->find($id);
        if (is_null($entity) === true)
            return $this->answerNotFound();

        return $this->correctAnswer($entity, Response::HTTP_OK, $arrSerializationGroups);
    }

    /**
     * @param Request $request
     * @param $entityName
     * @param callable|null $entityConfigurationFunction
     * @param array $arrSerializationGroups
     * @return mixed
     */
    protected function postEntity(Request $request, $entityName, callable $entityConfigurationFunction=null, $arrSerializationGroups=array('Default'))
    {
        $entity = $this->get('jms_serializer')->deserialize($request->getContent(), $entityName, "json");

        if (!is_null($entityConfigurationFunction))
            $entityConfigurationFunction($entity);

        return $this->saveValidating($entity, $arrSerializationGroups);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $entityName
     * @param callable|null $entityConfigurationFunction
     * @param array $arrSerializationGroups
     * @return mixed
     */
    protected function updateEntity(Request $request, $id, $entityName, callable $entityConfigurationFunction=null, $arrSerializationGroups=array('Default'))
    {
        try
        {
            $data = json_decode($request->getContent(), true);
            $data['id'] = $id;
            $entity = $this->get('jms_serializer')->deserialize(json_encode($data), $entityName, "json");

            if (!is_null($entityConfigurationFunction))
                $entityConfigurationFunction($entity);

            return $this->saveValidating($entity, $arrSerializationGroups);
        }
        catch(\Exception $exception)
        {
            return $this->correctAnswer(null, Response::HTTP_NOT_FOUND);
        }
    }
}