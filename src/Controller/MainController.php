<?php

 namespace App\Controller;

 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function homeAction()
    {
        return $this->render("home/index.html.twig");
    }

    /**
     * @Route("/doc_api", name="api_home")
     */
    public function homeApiAction()
    {
        return $this->render("api/index.html.twig");
    }

}