<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WeaponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{

    public function index(WeaponRepository $weaponRepository): Response
    {
        $weapons = $weaponRepository->findLatest();

        
        return $this->render('pages/home.html.twig', [
            'weapons' => $weapons
        ]);
    }
}
