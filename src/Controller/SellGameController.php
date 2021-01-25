<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellGameController extends AbstractController
{
    /**
     * @Route("/sell/game", name="sell_game")
     */
    public function index(): Response
    {
        return $this->render('sell_game/index.html.twig', [
            'controller_name' => 'SellGameController',
        ]);
    }
}
