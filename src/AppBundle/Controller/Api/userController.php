<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class userController extends ApiBaseController
{
    private function encriptaPassword(user $user)
    {
        if ($user->getPassword() !== null && $user->getPassword() !== '')
        {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encoded);
        }
    }

    /**
     * @Route("/users/", name="get_users")
     * @Method("GET")
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(user::class)->findAll();

        return $this->correctAnswer($users, Response::HTTP_OK, array('user'));
    }

    /**
     * @Route("/users/{id}", name="get_users")
     * @Method("GET")
     */
    public function getActionId($id)
    {
        return $this->getEntity($id, user::class, array('user'));
    }

    /**
     * @Route("/auth/register")
     * @Method("POST")
     */
    public function postAction(Request $request)
    {
        $funcionConfiguracionUsuario = function(user $user) use ($request)
        {
            $this->encriptaPassword($user);

            $user->setPhoto(
                $request->getUriForPath(
                    $this->getParameter('url_avatars_directory') . 'default.png'));
        };

        return $this->postEntity(
            $request, user::class,
            $funcionConfiguracionUsuario, array("usuario"));
    }

    /**
     * @Route("/users/password")
     * @Method("PUT")
     */
    public function putPasswordAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $data = json_decode($request->getContent(), true);

        $user->setPassword($data['password']);
        $this->encriptaPassword($user);

        return $this->saveValidating($user, array('usuario'));
    }


    /**
     * @Route("/users/{id}", name="delete_users")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        return $this->deleteEntity($id, user::class);
    }

    /**
     * @Route("/users/avatar")
     * @Method("PUT")
     */
    public function updateAvatarAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user)
        {
            $data = json_decode($request->getContent(), true);

            if ($data['avatar'] !== null)
            {
                $arr_avatar = explode(',', $data['avatar']);
                $avatar = base64_decode($arr_avatar[1]);

                if ($avatar)
                {
                    $fileName = $user->getName().'-'.time().'.jpg';
                    $filePath = $this->getParameter('avatars_directory').$fileName;
                    $urlAvatar = $request->getUriForPath($this->getParameter('url_avatars_directory').$fileName);

                    $user->setPhoto($urlAvatar);

                    $ifp = fopen($filePath, "wb");
                    if ($ifp)
                    {
                        $ok = fwrite($ifp, $avatar);
                        if ($ok)
                            return $this->saveValidating($user, array('usuario'));

                        fclose($ifp);
                    }
                }
            }

            $errores[] = "No se ha podido cargar la imagen del avatar";
            return $this->incorrectData($errores);
        }
        else
            return $this->answerNotFound();
    }

    /**
     * @Route("/profile")
     * @Method("GET")
     */
    public function profileAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user)
            return $this->correctAnswer($user, Response::HTTP_OK, array('usuario'));

        return $this->unauthorizedUser();
    }
}