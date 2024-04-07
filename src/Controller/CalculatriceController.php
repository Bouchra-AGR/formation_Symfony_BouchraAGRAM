<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CalculePrixTTC;


class CalculatriceController extends AbstractController
{
    #[Route('/add/{nb1}/{nb2}', name: 'addition')]
    public function addition($nb1, $nb2): Response
    {
        $sum = $nb1 + $nb2;
        return $this->render('resultCalcule.html.twig', [
            'operation' => 'Addition',
            'number1' => $nb1,
            'number2' => $nb2,
            'result' => $sum,
        ]);
    }

    #[Route('/sub/{nb1}/{nb}', name: 'subtraction')]
    public function subtraction($nb1, $nb): Response
    {
        $difference = $nb1 - $nb;
        return $this->render('resultCalcule.html.twig', [
            'operation' => 'Subtraction',
            'number1' => $nb1,
            'number2' => $nb,
            'result' => $difference,
        ]);
    }

    #[Route('/mult/{nb1}/{nb}', name: 'multiplication')]
    public function multiplication($nb1, $nb): Response
    {
        $difference = $nb1 * $nb;
        return $this->render('resultCalcule.html.twig', [
            'operation' => 'Multiplication',
            'number1' => $nb1,
            'number2' => $nb,
            'result' => $difference,
        ]);
    }

    #[Route('/div/{dividende}/{diviseur}', name: 'division')]
    public function division($dividende, $diviseur): Response
    {
        $operation = 'Division';
        $number1 = $dividende;
        $number2 = $diviseur;
        $result = ($diviseur != 0) ? $dividende / $diviseur : "Impossible de diviser par zéro";

        return $this->render('resultCalcule.html.twig', [
            'operation' => $operation,
            'number1' => $number1,
            'number2' => $number2,
            'result' => $result,
        ]);
    }

    #[Route('/calculer-prix-ttc/{prix}', name: 'addition')]
    public function calculePrixTTC(CalculePrixTTC $calculePrixTTC, float $prix): Response
    {
        $prixTTC = $calculePrixTTC->calculePrixTTC($prix);

        return $this->render('resultCalcule.html.twig', [
            'operation' => 'CalculePrixTTC',
            'number1' => null,
            'number2' => null,
            'result' => $prixTTC,
        ]);
    }
    
}