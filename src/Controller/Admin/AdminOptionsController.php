<?php

namespace App\Controller\Admin;

use App\Entity\Options;
use App\Form\OptionsType;
use App\Repository\OptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/options")
 */
class AdminOptionsController extends AbstractController
{
    /**
     * @Route("/", name="admin.options.index", methods={"GET"})
     */
    public function index(OptionsRepository $optionsRepository): Response
    {
        return $this->render('admin/options/index.html.twig', [
            'options' => $optionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="admin.options.create", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $option = new Options();
        $form = $this->createForm(OptionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();

            return $this->redirectToRoute('admin.options.index');
        }

        return $this->render('admin/options/create.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.options.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Options $option): Response
    {
        $form = $this->createForm(OptionsType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.options.index');
        }

        return $this->render('admin/options/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.options.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Options $option): Response
    {
        if ($this->isCsrfTokenValid('delete' . $option->getId(), $request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($option);
            $em->flush();
            $this->addFlash('success', 'Suppression effectuée');
        }

        return $this->redirectToRoute('admin.options.index');
    }
}
