<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
    * @Route("/user", name="user")
    */
    public function user()
    {
        $user = $this->getUser();
        return $this->render('user.html.twig', [
            'baskets' => $user->getBaskets(),
            'loans' => $user->getLoans(),
        ]);
    }
}
