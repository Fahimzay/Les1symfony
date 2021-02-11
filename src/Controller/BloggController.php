<?php

namespace App\Controller;

use App\Entity\Blogg;
use App\Form\BloggType;
use App\Repository\BloggRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blogg")
 */
class BloggController extends AbstractController
{
    /**
     * @Route("/", name="blogg_index", methods={"GET"})
     */
    public function index(BloggRepository $bloggRepository): Response
    {
        return $this->render('blogg/index.html.twig', [
            'bloggs' => $bloggRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="blogg_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blogg = new Blogg();
        $form = $this->createForm(BloggType::class, $blogg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blogg);
            $entityManager->flush();

            return $this->redirectToRoute('blogg_index');
        }

        return $this->render('blogg/new.html.twig', [
            'blogg' => $blogg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blogg_show", methods={"GET"})
     */
    public function show(Blogg $blogg): Response
    {
        return $this->render('blogg/show.html.twig', [
            'blogg' => $blogg,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blogg_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Blogg $blogg): Response
    {
        $form = $this->createForm(BloggType::class, $blogg);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blogg_index');
        }

        return $this->render('blogg/edit.html.twig', [
            'blogg' => $blogg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blogg_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Blogg $blogg): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogg->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blogg);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blogg_index');
    }
}
