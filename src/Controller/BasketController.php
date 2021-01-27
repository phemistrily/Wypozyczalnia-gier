<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\User;
use App\Repository\BasketLanesRepository;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends AbstractController
{
    private $basketLanesRepository;
    private $basketRepository;

    public function __construct(BasketRepository $basketRepository, BasketLanesRepository $basketLanesRepository)
    {
        $this->basketLanesRepository = $basketLanesRepository;
        $this->basketRepository = $basketRepository;
    }

    /**
     * @Route("/basket", name="basket")
     */
    public function index(Request $request): Response
    {
        $parameters = [];
        //$parameters['baskets'] = [];
        try {
            $user = $this->getUser();
            if (!$user instanceof User) {
                throw new EntityNotFoundException("Nie jesteś zalogowany");
            }
            $baskets = $user->getBaskets();

            $parameters['baskets'] = $baskets;
            $parameters['message'] = $request->get('message');
            $parameters['typeMessage'] = $request->get('typeMessage');
        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }
        return $this->render('basket/index.html.twig', $parameters);
    }

    /**
     * @Route("/deleteBasketLane", name="deleteBasketLane")
     */
    public function deleteBasketLane(Request $request): Response
    {
        $parameters = [];
        try {
            $basketLane = $this->basketLanesRepository->getById($request->get('id'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($basketLane);
            $entityManager->flush();
            $parameters['message'] = 'Pozycja w koszyku została usunięta';
            $parameters['typeMessage'] = 'success';
        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }
        return $this->redirectToRoute('basket', $parameters);
    }

    /**
     * @Route("/pay", name="pay")
     */
    public function pay(Request $request): Response
    {
        //mock payment
        $parameters = [];
        try {
            $basket = $this->basketRepository->getById($request->get('id'));

            if ($basket->getStatus() !== 'NEW') {
                throw new \Exception('Nie możesz zapłacić za ten koszyk');
            }

            $basket->setStatus('PAID');

            $newBasket = new Basket($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newBasket);
            $entityManager->flush();

            $parameters['message'] = 'Pomyślnie zapłacono za koszyk';
            $parameters['typeMessage'] = 'success';
        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }
        return $this->redirectToRoute('basket', $parameters);
    }
}
