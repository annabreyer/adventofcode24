<?php

namespace App\Controller;

use App\Manager\DayFiveManager;
use App\Manager\DayFourManager;
use App\Manager\DayOneManager;
use App\Manager\DayThreeManager;
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

    #[Route('/day/3', name: 'app_day_three')]
    public function dayThree(DayThreeManager $dayThreeManager): Response
    {
        $result = $dayThreeManager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }

    #[Route('/day/4', name: 'app_day_four')]
    public function dayFour(DayFourManager $dayFourManager): Response
    {
        $result = $dayFourManager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }

    #[Route('/day/5', name: 'app_day_five')]
    public function dayFive(DayFiveManager $manager): Response
    {
        $result = $manager->getResult();

        return $this->render('index.html.twig', [
            'day' => 1,
            'result' => $result,
        ]);
    }
}
