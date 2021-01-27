<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SoldGames;
use App\Entity\User;
use App\Exception\Product\ProductNotFound;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SellGameType;

class SellGameController extends AbstractController
{
    /**
     * @Route("/sell/game", name="sell_game")
     * @throws ProductNotFound
     */
    public function index(Request $request): Response
    {
        $parameters = [];
        $form = $this->createForm(SellGameType::class);
        $parameters['form'] = $form->createView();

        $parameters['message'] = $request->get('message');
        $parameters['typeMessage'] = $request->get('typeMessage');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $sellGameDataForm = $form->getData();

                if (!$sellGameDataForm['product'] instanceof Product) {
                    throw new \Exception("Nie znaleziono produktu");
                }

                $user = $this->getUser();

                if(!$user instanceof User) {
                    throw new \Exception("Nie znaleziono użytkownika");
                }

                $soldGameEntity = new SoldGames($user, $sellGameDataForm['product'], (float) $sellGameDataForm['price']);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($soldGameEntity);
                $entityManager->flush();
                $parameters['message'] = 'Zaproponowano sprzedaż gry. Gdy zmieni się status powiadomimy Cię';
                $parameters['typeMessage'] = 'success';
            } catch (\Exception $e) {
                $parameters['message'] = $e->getMessage();
                $parameters['typeMessage'] = 'fail';
            }

            return $this->redirectToRoute('sell_game', $parameters);
        }
        return $this->render('sell_game/index.html.twig', $parameters);
    }
}
