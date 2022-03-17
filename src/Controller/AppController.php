<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    public function header(CategoryRepository $categoryRepository): Response
    {
        return $this->render('_header.html.twig', [
            'categories' => $categoryRepository->findBy(['active' => true], ['position' => 'ASC'])
        ]);
    }
}
