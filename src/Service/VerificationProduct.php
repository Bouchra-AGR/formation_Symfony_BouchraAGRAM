<?php

namespace App\Service;

Class VerificationProduct
{
    
    public function validate(string $name, float $price, int $quantity): array
    {
        $errors = [];

        if (empty($name)) {
            $errors[] = 'Le nom du produit est requis.';
        }

        if ($price <= 0) {
            $errors[] = 'Le prix du produit doit être supérieur à zéro.';
        }

        if ($quantity <= 0) {
            $errors[] = 'La quantité du produit doit être supérieure à zéro.';
        }

        return $errors;
    }

}