<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function indexAction(UserRepository $userRepository): Response
    {

        //on cherche les utilisateurs enregistré dans la base...
        $em = $this->getDoctrine()->getManager()->getRepository(User::class); 

        //on trie les utilisateur par leur nom de famille en ordre alphabetique...
        $user = $em->findBy([],["lastname"=>"ASC"]);

        //...puis on les affiche dans le template
        return $this->render('user/index.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function newAction(Request $request): Response
    {
        //on cree un nouvel utilisateur
        $user = new User();

        //on cree le formulaire qui possedera les champs liés aux attributs de l'utilisateur
        $form = $this->createForm(UserType::class, $user);

        //controle de la validation du formulaire
        $form->handleRequest($request);

        //si le formulaire est validé et que les données entrées sont exactes...
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /*
            experimental
            //on verifie que l'age de l'utilisateur ne depasse pas 150 ans

            if($user->getBirthdate() < date('Y-m-d', strtotime('-150 years'))
            {
                return $this->redirectToRoute('user_index', [], Response::HTTP_BAD_REQUEST);
            }
            */

            //si ok on prepare l'enregistrement...
            $entityManager->persist($user);

            //...et on l'enregistre...
            $entityManager->flush();

            //puis on se redirige vers la page affichant les utilisateurs
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        //affiche le formulaire de création d'un utilisateur
        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
