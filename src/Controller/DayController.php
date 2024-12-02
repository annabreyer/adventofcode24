<?php

namespace App\Controller;

use App\Manager\DayOneManager;
use App\Manager\DayTwoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DayController extends AbstractController
{
    #[Route('/day/1', name: 'app_day_one')]
    public function dayOne(DayOneManager $dayOneManager): Response
    {
        $result = $dayOneManager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }

    #[Route('/day/2', name: 'app_day_two')]
    public function dayTwo(DayTwoManager $dayTwoManager): Response
    {
        $result = $dayTwoManager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }
}
