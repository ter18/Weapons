<?php
namespace App\Controller;

use App\Entity\Weapon;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeaponsController extends AbstractController
{

    private $repository;

    public function __construct(WeaponRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
    }

    public function index(): Response
    {
        $weapon = $this->repository->findAll();

        return $this->render('weapon/weapons.html.twig',[
            'current_menu' => 'weapons',
            'weapon' => $weapon
        ]);
    }

    /**
     * @Route("/weapon/{slug}-{id}", name="weapon.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @param Weapon $weapon
     * @param String $slug
     */
    public function show(Weapon $weapon, string $slug): Response
    {
        if($weapon->getSlug() !== $slug) {
            return $this->redirectToRoute('weapon.show', [
                'id' => $weapon->getId(),
                'slug' => $weapon->getSlug()
            ], 301);
        }
        return $this->render('weapon/show.html.twig', [
            'current_menu' => 'weapons',
            'weapon' => $weapon
        ]);
    }
}