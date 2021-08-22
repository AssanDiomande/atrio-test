<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{

    /**
     * @Rest\Post("/user/create")
     * @ParamConverter("user", 
     * converter="fos_rest.request_body"    )
     */
    public function createAction(User $user, ConstraintViolationList $violations,UserPasswordEncoderInterface $encoder)
    {

        if (count($violations)) {
            return new Response($violations, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response('object created', Response::HTTP_CREATED);
    }


    /**
     * @Rest\Get("/user")
     */
    public function showAction()
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findAll();

        return $user;
    }

    /**
     * @Rest\Get("/user/{id}")
     */
    public function showOneActioe(User $user)
    {
        return $user;
    }

     /**
     * @Rest\Delete("/user/delete/{id}")
     */
    public function deleteAction(User $user,$id)
    {
       
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response('object whith id '.$id.' deleted',Response::HTTP_ACCEPTED);
    }

    /**
     * @Rest\Put("/update/{id}")
     * @ParamConverter("u", 
     * converter="fos_rest.request_body"    )
     */
    public function updateAction(Request $request, User $u,$id,UserPasswordEncoderInterface $encoder)
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBy(["id"=>$id]);

        $user->setFirstname($u->getFirstname());
        $user->setLastname($u->getLastName());
        $user->setBirthdate($u->getBirthdate());


        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response('object whith id '.$id.' updated',Response::HTTP_ACCEPTED);
    }
}