<?php

namespace App\Controller;

use App\Service\IGDBServiceManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param IGDBServiceManager $manager
     *
     * @return Response
     * @throws Exception
     */
    public function index(IGDBServiceManager $manager)
    {
        $popularGames = $manager->getPopularGames();
        $recentlyReviewedGames = $manager->getRecentlyReviewedGames();
        $mostAnticipatedGames = $manager->getMostAnticipatedGames();
        $comingSoonGames = $manager->getComingSoonGames();

        return $this->render('page/index.html.twig', [
            'popularGames' => $popularGames,
            'recentlyReviewedGames' => $recentlyReviewedGames,
            'mostAnticipatedGames' => $mostAnticipatedGames,
            'comingSoonGames' => $comingSoonGames
        ]);
    }

    /**
     * @Route("/show", name="show")
     */
    public function show()
    {
        return $this->render('page/show.html.twig');
    }
}
