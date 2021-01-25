<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LendGameController extends AbstractController
{
    /**
     * @Route("/lend/game", name="lend_game")
     */
    public function index(): Response
    {
        return $this->render('lend_game/index.html.twig', [
            'controller_name' => 'LendGameController',
        ]);
    }
}
