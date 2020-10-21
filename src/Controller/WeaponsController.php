<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Weapon;
use App\Entity\WeaponSearch;
use App\Form\ContactType;
use App\Form\WeaponSearchType;
use App\Notification\ContactNotification;
use App\Repository\WeaponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeaponsController extends AbstractController
{

    private $repository;

    public function __construct(WeaponRepository $repository)
    {
        $this->repository = $repository;
    }

 
    public function index(PaginatorInterface $paginator, Request $request): Response
    {   
        $search = new WeaponSearch();
        $form = $this->createForm(WeaponSearchType::class, $search);
        $form->handleRequest($request);
        $weapon = $paginator->paginate(
            $this->repository->findAllQuery($search), 
            $request->query->getInt('page', 1), 
            12
        );

        return $this->render('weapon/weapons.html.twig',[
            'current_menu' => 'weapons',
            'weapons' => $weapon,
            'form_search' => $form->createView()
        ]);
    }

    /**
     * @Route("/weapon/{slug}-{id}", name="weapon.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     * @param Weapon $weapon
     * @param String $slug
     */
    public function show(Weapon $weapon, string $slug, Request $request, ContactNotification $notification): Response
    {
        if($weapon->getSlug() !== $slug) {
            return $this->redirectToRoute('weapon.show', [
                'id' => $weapon->getId(),
                'slug' => $weapon->getSlug()
            ], 301);
        }
        $contact = new Contact();
        $contact->setWeapon($weapon);
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success','Votre email a bien été envoyé');
            return $this->redirectToRoute('weapon.show', [
                'id' => $weapon->getId(),
                'slug' => $weapon->getSlug()
            ]);
        }

        return $this->render('weapon/show.html.twig', [
            'current_menu' => 'weapons',
            'weapon' => $weapon,
            'form_contact' => $form->createView()
        ]);
    }
}