<?php

namespace App\Service;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CalculePrixTTC;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\VerificationProduct;


class ProductFormHandler
{
    private $calculePrixTTC;
    private $validationProduct;


    public function __construct(CalculePrixTTC $calculePrixTTC, VerificationProduct $validationProduct)
    {
        $this->calculePrixTTC = $calculePrixTTC;
        $this->validationProduct = $validationProduct;
    }

    public function handle(Request $request)
    {
            /*
            $idCounter = $this->session->get('id_counter', 1);

            $products = $this->session->get('products', []);
            $products[$idCounter] = $product;   
            $this->session->set('products', $products);
            $this->session->set('id_counter', $idCounter);*/

            
            $name = $request->request->get('name');
            $priceHT = $request->request->get('price');
            $quantity = $request->request->get('quantity');
            $description = $request->request->get('description');

            $errors = $this->validationProduct->validate($name,(float) $priceHT,(int) $quantity);

            if (count($errors) > 0) {
                
                return $errors;
            }
            
            $idCounter = $request->getSession()->get('id_counter', 1);

            $priceTTC = $this->calculePrixTTC->calculePrixTTC($priceHT);

            $product = new Product();
            $product->setId($idCounter);
            $product->setName($name);
            $product->setPrice($priceTTC);
            $product->setQuantity($quantity);
            $product->setDescription($description);

            $products = $request->getSession()->get('products', []);
            $products[$idCounter] = $product;   
            $request->getSession()->set('products', $products);

            $idCounter++;
            $request->getSession()->set('id_counter', $idCounter);
    }
}