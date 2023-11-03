<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private TeamRepository $teamRepository;

    public function __construct(EntityManagerInterface $entityManager, TeamRepository $teamRepository)
    {
        $this->entityManager = $entityManager;
        $this->teamRepository = $teamRepository;
    }

    #[Route('/teams', methods: ['GET'])]
    public function showAll()
    {
        $teams = $this->teamRepository->findAll();

        return $this->render('team/default.html.twig', ['teams' => $teams]);
    }

    #[Route('/teams', methods: ['POST'])]
    public function add(Request $request)
    {
        $team = new Team();
        $team->setName($request->get('name'));

        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $this->render('return.html.twig', ['backUrl' => '/teams']);
    }

    #[Route('/teams/{id}', methods: ['DELETE'])]
    public function delete(int $id)
    {
        $team = $this->teamRepository->find($id);

        $this->entityManager->remove($team);
        $this->entityManager->flush();

        return $this->render('return.html.twig', ['backUrl' => '/teams']);
    }
}