<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\WordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     */
    public function index(WordRepository $wordRepo, TypeRepository $typeRepo)
    {
        $words = $wordRepo->findAll();
        $types = $typeRepo->findAll();
        return $this->render('test/index.html.twig', [
            'words' => $words,
            'types' => $types,
        ]);
    }
}
