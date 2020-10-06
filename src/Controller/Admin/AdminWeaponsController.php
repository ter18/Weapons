<?php

namespace App\Controller\Admin;

use App\Entity\Weapon;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminWeaponsController extends AbstractController
{
    /**
     *
     * @var WeaponRepository
     */
    private $weaponRepository;

    /**
     *
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(WeaponRepository $weaponRepository, EntityManagerInterface $em)
    {
        $this->weaponRepository = $weaponRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/weapon", name="admin.weapon.index")
     */
    public function index()
    {
        $weapons = $this->weaponRepository->findAll();
        return $this->render('admin/weapon/index.html.twig', compact('weapons'));
    }


    /**
     * @Route("/admin/weapon/create", name="admin.weapon.new")
     * @param Request $request
     */
    public function new(Request $request)
    {
        $weapon = new Weapon();
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($weapon);
            $this->em->flush();
            $this->addFlash('success', "GG BRO");
            return $this->redirectToRoute('admin.weapon.index');
        }

        return $this->render('admin/weapon/create.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/weapon/{id}", name="admin.weapon.edit", methods="GET|POST")
     * @param  Weapon $weapon
     * @param  Request $request
     */
    public function edit(Weapon $weapon, Request $request)
    {
        $form = $this->createForm(WeaponType::class, $weapon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', "GG BRO");
            return $this->redirectToRoute('admin.weapon.index');
        }

        return $this->render('admin/weapon/edit.html.twig', [
            'weapon' => $weapon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/weapon/{id}", name="admin.weapon.delete", methods="DELETE")
     * @param  Weapon $weapon
     * @param Request $request
     */
    public function delete(Weapon $weapon, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $weapon->getId(), $request->get('_token'))) {
            $this->em->remove($weapon);
            $this->em->flush();
            $this->addFlash('success', "GG BRO");
        } 
        return $this->redirectToRoute('admin.weapon.index');
    }
}
