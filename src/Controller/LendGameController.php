<?php

namespace App\Controller;

use App\Entity\Loans;
use App\Entity\Product;
use App\Entity\User;
use App\Form\LendGameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LendGameController extends AbstractController
{
    /**
     * @Route("/lend/game", name="lend_game")
     */
    public function index(Request $request): Response
    {
        $parameters = [];
        $form = $this->createForm(LendGameType::class);
        $parameters['form'] = $form->createView();

        $parameters['message'] = $request->get('message');
        $parameters['typeMessage'] = $request->get('typeMessage');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $lendGameDataForm = $form->getData();

                if (!$lendGameDataForm['product'] instanceof Product) {
                    throw new \Exception("Nie znaleziono produktu");
                }

                if ($lendGameDataForm['product']->getQuantity() === 0) {
                    throw new \Exception('Brak gry na stanie');
                }

                $user = $this->getUser();

                if(!$user instanceof User) {
                    throw new \Exception("Nie znaleziono użytkownika");
                }

                if($lendGameDataForm['dateExpectedFinishLoan'] < new \DateTime()) {
                    throw new \Exception("Data wypożyczenia jest nie poprawna");
                }

                $lendGameEntity = new Loans($user, $lendGameDataForm['product'], $lendGameDataForm['dateLoan'], $lendGameDataForm['dateExpectedFinishLoan']);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($lendGameEntity);
                $entityManager->flush();
                $parameters['message'] = 'Wypożyczono grę';
                $parameters['typeMessage'] = 'success';
            } catch (\Exception $e) {
                $parameters['message'] = $e->getMessage();
                $parameters['typeMessage'] = 'fail';
            }
        }
        return $this->render('lend_game/index.html.twig', $parameters);
    }
}
