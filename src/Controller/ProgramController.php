<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;



class ProgramController extends AbstractController
{
    /**
     * @Route("/programs/", name="program_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        
            return $this->render('program/index.html.twig', [
            'programs' => $programs
            ]);
    }

    /**
     * @Route("/programs/{id}", methods={"GET"} ,requirements={"id"="\d+"}, name="program_show")
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$id.' found in program\'s table.'
        );
    }

    $seasons = $program->getSeasons();

    return $this->render('program/show.html.twig', [
        'program' => $program,
        'seasons' => $seasons
    ]);
    }

    /**
     * @Route("{programId}/seasons/{seasonId}", requirements={"seasonId"="\d+"}, methods={"GET"}, name="program_season_show")
     */
    public function showSeason(int $programId, int $seasonId)
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $programId]);

        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy(['id' => $seasonId]);

        $episodes = $season->getEpisodes();

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);

    }
}