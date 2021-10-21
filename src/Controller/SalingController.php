<?php

namespace App\Controller;

use App\Entity\Saling;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SalingController extends AbstractController
{

    private $entityManager;

    public function __construct (EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/points-de-vente", name="saling")
     */
    public function index(): Response
    {
        $salings = $this->entityManager->getRepository(Saling::class)->findAll();
        return $this->render('saling/index.html.twig', [
            'salings'=>$salings
        ]);
    }

    /**
     * @Route("/point-de-vente/{id}", name="singlesaling")
     */
    public function show($id): Response
    {

        $saling = $this->entityManager->getRepository(Saling::class)->find($id);
        if(!$saling){

            return $this->redirectToRoute('saling');
        }

        return $this->render('saling/single.html.twig',[
            'saling' => $saling,
            
        ]);
    }
}
