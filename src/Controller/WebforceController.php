<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WebforceController extends AbstractController
{
    /**
     * @Route("/webforce", name="webforce")
     */
    public function index()
    {
        return $this->render('webforce/index.html.twig', [
            'controller_name' => 'WebforceController',
        ]);
    }
}
