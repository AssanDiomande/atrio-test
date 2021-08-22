<?php

 namespace App\Controller;

 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render("home/index.html.twig");
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function signin()
    {
        return $this->render("home/connect.html.twig");
    }

}