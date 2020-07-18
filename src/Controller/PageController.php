<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/show", name="show")
     */
    public function show()
    {
        return $this->render('page/show.html.twig');
    }
}
