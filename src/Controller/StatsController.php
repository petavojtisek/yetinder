<?php

namespace App\Controller;

use App\Facade\PostFacade;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]

final class StatsController extends AbstractController
{


    #[Route('/stats', name: 'stats',  methods: ['GET'])]
    public function stats(PostFacade $postFacade, Connection $connection) : Response{

        $dateTo = new \DateTimeImmutable('today 24:00');
        $dateFrom = new \DateTimeImmutable('-10 day midnight');
        $topPositions = 3;

        //todo setup by format, start, end , topositions
        $stats = $postFacade->getStats('%Y-%m-%d', $dateFrom, $dateTo, $topPositions);
        //$stats = $postFacade->getStats('%Y-%m', $dateFrom, $dateTo, $topPositions);
        return $this->render('stats/stats.html.twig', ['stats'=>$stats, 'topPositions'=>$topPositions]);
    }

}