<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\BasketLanes;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\BasketRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

class ProductController extends AbstractController
{
    private $productRepository;
    private $basketRepository;

    public function __construct(ProductRepository $productController, BasketRepository $basketRepository)
    {
        $this->productRepository = $productController;
        $this->basketRepository = $basketRepository;
    }

    /**
     * @Route("/product", name="product")
     */
    public function index(Request $request): Response
    {
        $parameters = [];
        try {
            $productId = (int) $request->get('id');

            if (!$productId) {
                throw new InvalidArgumentException("Nie znaleziono produktu. Wybierz poprawny produkt");
            }

            $parameters['product'] = $this->productRepository->getById($productId);
            $parameters['message'] = $request->get('message');
            $parameters['typeMessage'] = $request->get('typeMessage');
        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }

        return $this->render('product/index.html.twig', $parameters);
    }

    /**
     * @Route("/product/addToBasket", name="add_to_basket")
     */
    public function add(Request $request): Response
    {
        $parameters = [];
        try {
            $user = $this->getUser();
            if (!$user instanceof User) {
                throw new EntityNotFoundException("Nie jesteś zalogowany");
            }
            $productId = $request->get('productId');
            $quantity = $request->get('quantity');
            $product = $this->productRepository->getById($productId);
            $basket = $this->basketRepository->findNewBasketForUser($user->getId());
            if (!$basket[0] instanceof Basket) {
                throw new EntityNotFoundException("Nie znaleziono aktywnego koszyka dla użytkownika");
            }

            $basketLane = new BasketLanes($basket[0], $product, $quantity);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($basketLane);
            $entityManager->flush();

            $parameters['id'] = $product->getId();
            $parameters['message'] = 'Dodano grę do koszyka';
            $parameters['typeMessage'] = 'success';
        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }

        return $this->redirectToRoute('product', $parameters);
    }
}
