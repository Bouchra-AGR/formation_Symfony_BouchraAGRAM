<?php

namespace App\Service;

Class CalculePrixTTC
{
    
    private $tauxTVA;

    public function __construct(float $tauxTVA)
    {
        $this->tauxTVA = $tauxTVA;
    }

    public function calculePrixTTC(float $prixHT): float
    {
        $prixTTC = $prixHT * (1 + $this->tauxTVA);

        return $prixTTC;
    }

    public function getTauxTVA(): float
    {

        return $this->tauxTVA;
    }
}