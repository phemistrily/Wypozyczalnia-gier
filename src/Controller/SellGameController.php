<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SellGameType;

class SellGameController extends AbstractController
{
    /**
     * @Route("/sell/game", name="sell_game")
     */
    public function index(): Response
    {
        $form = $this->createForm(SellGameType::class);
        return $this->render('sell_game/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
