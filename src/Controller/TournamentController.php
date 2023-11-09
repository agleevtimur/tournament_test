<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Repository\TeamRepository;
use App\Repository\TournamentRepository;
use App\Service\OrderStrategy\OrderShuffleStrategy;
use App\Service\ScheduleGenerator\DefaultScheduleGenerator;
use App\Service\ScheduleGenerator\ScheduleGeneratorManager;
use App\Service\ScheduleGenerator\Strategy\BaseScheduleGeneratorStrategy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private TournamentRepository $tournamentRepository;
    private TeamRepository $teamRepository;

    public function __construct(EntityManagerInterface $entityManager, TournamentRepository $tournamentRepository, TeamRepository $teamRepository)
    {
        $this->entityManager = $entityManager;
        $this->tournamentRepository = $tournamentRepository;
        $this->teamRepository = $teamRepository;
    }

    #[Route('/tournaments', methods: ['GET'])]
    public function showAll()
    {
        $tournaments = $this->tournamentRepository->findAll();
        $teams = $this->teamRepository->findAll();

        return $this->render('tournament/default.html.twig', ['tournaments' => $tournaments, 'teams' => $teams]);
    }

    #[Route('/', methods: ['GET'])]
    public function showAllOnlyTournaments()
    {
        $tournaments = $this->tournamentRepository->findAll();
        return $this->render('tournament/list.html.twig', ['tournaments' => $tournaments]);
    }


    #[Route('/tournaments/{name}', methods: ['GET'])]
    public function show(string $name)
    {
        $tournament = $this->tournamentRepository->findOneBy(['name' => $name]);

        return $this->render('tournament/single.html.twig', ['schedule' => json_decode($tournament->getSchedule(), true)]);
    }


    #[Route('/tournaments', methods: ['POST'])]
    public function add(Request $request, DefaultScheduleGenerator $scheduleGenerator)
    {
        $teams = $this->teamRepository->findBy(['id' => $request->get('team_selection')]);

        $schedule = $scheduleGenerator->generate($teams);

        $tournament = (new Tournament())
            ->setName($request->get('name'))
            ->setTeams($teams)
            ->setSchedule(json_encode($schedule));

        $this->entityManager->persist($tournament);
        $this->entityManager->flush();

        return $this->render('return.html.twig', ['backUrl' => '/tournaments']);
    }

    #[Route('/tournaments/{id}', methods: ['DELETE'])]
    public function delete(int $id)
    {
        $tournament = $this->tournamentRepository->find($id);

        $this->entityManager->remove($tournament);
        $this->entityManager->flush();

        return $this->render('return.html.twig', ['backUrl' => '/tournaments']);
    }
}