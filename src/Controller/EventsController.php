<?php

namespace App\Controller;

use App\Entity\Events;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{

    private $entityManager;

    public function __construct (EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/events", name="events")
     */
    public function index(Request $request): Response
    {

        $events = $this->entityManager->getRepository(Events::class)->findAll();
        return $this->render('events/index.html.twig', [
            'events'=>$events
        ]);
    }

    /**
     * @Route("/event/{id}", name="event")
     */
    public function show($id): Response
    {

        $event = $this->entityManager->getRepository(Events::class)->find($id);
        if(!$event){

            return $this->redirectToRoute('events');
        }

        return $this->render('events/single.html.twig',[
            'event' => $event,
            
        ]);
    }
}
