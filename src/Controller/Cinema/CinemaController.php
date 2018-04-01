<?php

namespace App\Controller\Cinema;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaController extends Controller
{
  /**
     * @Route("/", name="entry")
     */
     public function entryAction(Request $request)
     {
         return $this->redirect($this->generateUrl('cinema'));
     }

    /**
     * @Route("/cinema", name="cinema")
     */
    public function index()
    {
        return $this->render('cinema/index.html.twig', [
            'controller_name' => 'CinemaController',
        ]);
    }
}
