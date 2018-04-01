<?php

namespace App\Controller\Cinema;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cinema;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    public function index(Request $request)
    {
       $cinema = new Cinema();

       $form = $this->createFormBuilder($cinema)
           ->add('nome', TextType::class)
           ->add('citta', TextType::class)
           ->add('sale', IntegerType::class)
           ->add('save', SubmitType::class, array('label' => 'Create Task'))
           ->getForm();
           if ($request->isMethod('POST')) {
                       // handle the first form
                       $form->handleRequest($request);
                       // set field in to db //
                       $nome = $form['nome']->getData();
                       $citta = $form['citta']->getData();
                       $sale = $form['sale']->getData();

                       $cinema->setNome($nome);
                       $cinema->setCitta($citta);
                       $cinema->setSale($sale);

                       $sn = $this->getDoctrine()->getManager();
                       // control form //
                         if($form->isSubmitted() &&  $form->isValid()){
                           // insert in to db //
                           $sn -> persist($cinema);
                           $sn -> flush();
                           // alert success //
                           $request->getSession()
                           ->getFlashBag()
                           ->add('success', 'Grazie per esserti iscritto, riceverai un email di conferma');
                }
              }
        return $this->render('cinema/index.html.twig', [
            'controller_name' => 'CinemaController',
            'form' => $form->createView(),
        ]);
    }
}
