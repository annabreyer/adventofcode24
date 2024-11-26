<?php

namespace App\Controller;

use App\Manager\DayOneManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DayOneController extends AbstractController
{
    #[Route('/day/one', name: 'app_day_one')]
    public function index(DayOneManager $dayOneManager): Response
    {
        $result = $dayOneManager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }
}
