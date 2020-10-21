<?php

namespace App\Controller\Admin;

use App\Entity\Options;
use App\Entity\Weapon;
use App\Form\WeaponType;
use App\Repository\WeaponRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
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
            $this->loadFile($form, $weapon);
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
            $this->loadFile($form, $weapon);
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
            $filesystem = new FileSystem();
            $filesystem->remove('uploads/' . $weapon->getImage());
            $this->em->remove($weapon);
            $this->em->flush();
            $this->addFlash('success', 'Suppression effectuée');
        }
        return $this->redirectToRoute('admin.weapon.index');
    }
    
    /**
     * @param  form $form
     * @param  Weapon $weapon
     * @return void
     */
    private function loadFile($form, Weapon $weapon)
    {
        $file = $form->get('my_file')->getData();
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $newFilename = md5($originalFilename) . '-' . uniqid() . '.' . $file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $w = $weapon->getImage();
            if(isset($w) && ($weapon->getImage() !== $newFilename))
            {
                $filesystem = new FileSystem();
                $filesystem->remove('uploads/' . $weapon->getImage());
            }
            $weapon->setImage($newFilename);
        }
    }
}
