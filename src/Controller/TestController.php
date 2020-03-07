<?php

namespace App\Controller;

use App\Entity\Traduction;
use App\Entity\Type;
use App\Entity\Word;
use App\Repository\TypeRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     */
    public function index(WordRepository $wordRepo, TypeRepository $typeRepo, EntityManagerInterface $em)
    {
        $words = $wordRepo->findAll();
        $types = $typeRepo->findAll();

        $traduction = new Traduction();
        $traduction->setSpelling('touklklkste');
        //$em->persist($traduction);

        $type = $typeRepo->findOneBy(["id" => "49"]);

        $word = new Word();
        $word->setSpelling("Test en russe pour nom propre")->addTraduction($traduction)->setType($type);
        $em->persist($word);

        $em->flush();

        return $this->render('test/index.html.twig', [
            'words' => $words,
            'types' => $types,
        ]);
    }
}
