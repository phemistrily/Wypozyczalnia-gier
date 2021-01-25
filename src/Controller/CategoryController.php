<?php

namespace App\Controller;


use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends AbstractController
{
    private $productCategoryRepository;

    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request): Response
    {
        $parameters = [];
        try {
            $categoryId = (int) $request->get('id');

            if (!$categoryId) {
                throw new InvalidArgumentException("Nie znaleziono kategorii. Wybierz kategorię");
            }

            $category = $this->productCategoryRepository->getById($categoryId);

            $parameters['products'] = $category->getProducts();

        } catch (\Exception $e) {
            $parameters['message'] = $e->getMessage();
            $parameters['typeMessage'] = 'fail';
        }




        return $this->render('category/index.html.twig', $parameters);
    }
}
