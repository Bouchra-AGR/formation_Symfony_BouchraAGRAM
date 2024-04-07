<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\CalculePrixTTC;
use App\Service\ProductFormHandler;
use App\Service\VerificationProduct;


class ProductController extends AbstractController
{
    //private $calculePrixTTC;
    private $productFormHandler;
    private $validationProduct;


    /*public function __construct(CalculePrixTTC $calculePrixTTC)
    {
        $this->calculePrixTTC = $calculePrixTTC;
    }*/
    
    public function __construct(ProductFormHandler $productFormHandler,VerificationProduct $validationProduct)
    {
        $this->productFormHandler = $productFormHandler;
        $this->validationProduct = $validationProduct;
    }


    #[Route('/clear-session', name: 'clear_session')]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash('success', 'La session a été nettoyée avec succès.');

        return $this->redirectToRoute('list_product');
    }

    #[Route('/product/formulaire', name: 'formulaire')]
    public function addForm(): Response
    {
        return $this->render('product/formulaire.html.twig');
    }

    #[Route('/product/add', name: 'add_product', methods: ['POST'])]
    public function add(Request $request): Response
    {

        $errors = $this->productFormHandler->handle($request);

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
            return $this->redirectToRoute('list_product');
        }
        
        $this->addFlash('success', 'Le produit a été ajouté avec succès.');
        return $this->redirectToRoute('list_product');   
    }

    #[Route('/product/list', name: 'list_product')]
    public function list(Request $request): Response
    {
        $products = $request->getSession()->get('products', []);
        $searchTerm = $request->query->get('search');

        if ($searchTerm) {
            $filteredProducts = [];
            foreach ($products as $product) {
                if (stripos($product->getName(), $searchTerm) !== false) {
                    $filteredProducts[] = $product;
                }
            }
            $products = $filteredProducts;
        }
    
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}/details', name: 'details')]
    public function details(Request $request, int $id): Response{
        $products=$request->getSession()->get('products', []);
        $product = $products[$id];
        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/delete', name: 'delete')]
    public function delete (Request $request, int $id){
        $products = $request->getSession()->get('products', []);

    if (array_key_exists($id, $products)) {
        unset($products[$id]);
        $request->getSession()->set('products', $products);
        $this->addFlash('success', 'Le produit a été supprimé avec succès.');
    } else {
        $this->addFlash('error', 'Le produit que vous essayez de supprimer n\'existe pas.');
    }
        return $this->redirectToRoute('list_product');
    }


}