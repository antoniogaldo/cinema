<?php

namespace App\Controller\Cinema;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cinema;
use App\Forms\CinemaType;

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
       $repository = $this->getDoctrine()->getRepository(Cinema::class);
       // look for a single Product by its primary key (usually "id")
       $cinemaviews = $repository->findAll();
       $cinema = new Cinema();
       $form = $this->createForm(CinemaType::class, $cinema);
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
                           unset($form);
                           $cinema = new Cinema();
                           $form = $this->createForm(CinemaType::class, $cinema);
                }
                else {
                  // alert insucces //
                  $request->getSession()
                  ->getFlashBag()
                  ->add('notsuccess', 'Email gia presente');
                }
        // redirect home //
        $this->redirect($this->generateUrl('cinema'));
      }
        return $this->render('cinema/index.html.twig', [
            'controller_name' => 'CinemaController',
            'form' => $form->createView(),
            'cinemaviews'=> $cinemaviews,
        ]);
    }
     /**
     * @Route("/cinema/edit/{id}", name="edit")
     */
    public function updateAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cinema = $entityManager->getRepository(Cinema::class)->find($id);

        if (!$cinema) {
            throw $this->createNotFoundException(
                'No cinema found for id '.$id
            );
        }
        $cinema = new Cinema();
        $form = $this->createForm(CinemaType::class, $cinema);
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
                        unset($form);
                        $cinema = new Cinema();
                        $form = $this->createForm(CinemaType::class, $cinema);
             }
             else {
               // alert insucces //
               $request->getSession()
               ->getFlashBag()
               ->add('notsuccess', 'Email gia presente');
             }
     // redirect home //
     $this->redirect($this->generateUrl('cinema'));
   }
        return $this->redirectToRoute('cinema', [
            'id' => $cinema->getId()
        ]);
    }



    /**
    * @Route("/cinema/delete/{id}", name="delete")
    */
   public function deleteAction($id)
   {
       $entityManager = $this->getDoctrine()->getManager();
       $cinema = $entityManager->getRepository(Cinema::class)->find($id);

       if (!$cinema) {
           throw $this->createNotFoundException(
               'No cinema found for id '.$id
           );
       }
       $entityManager->remove($cinema);
       $entityManager->flush();
       return $this->render('cinema/index.html.twig');
   }
}
