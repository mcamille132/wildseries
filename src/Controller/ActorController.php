<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Actor;

/**
 * @Route("/actors", name="actor_")
 */
class ActorController extends AbstractController
{
     /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findAll();
        
            return $this->render('actor/index.html.twig', [
            'actors' => $actors]);
    }

    
    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show(Actor $actor): Response {
        
        $programs = $actor->getPrograms();

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs
        ]);
    }
}