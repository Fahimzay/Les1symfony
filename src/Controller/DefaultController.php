<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $blog = $entityManager ->getRepository(Blog::class)->findAll();
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'blogs' => $blog,
        ]);
    }
}
