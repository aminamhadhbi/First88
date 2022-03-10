<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\EvenementRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AController extends AbstractController
{
    /**
     * @Route("/a", name="a")
     */
    public function index(): Response
    {
        return $this->render('a/index.html.twig', [
            'controller_name' => 'AController',
        ]);
    }
    /**
     * @param ReservationRepository $repository
     * @return Response
     * @Route ("/affiche8", name="affiche8")
     */
    function Affiche( ){
        $repo=$this->getDoctrine()->getRepository(Reservation::class);

        $Reservation=$repo->findAll();

        return $this->render('Reservation/backk.html.twig',
            [
                'Reservation'=>$Reservation,
            ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/Ajou",name="Ajou")
     */

    public function Reservation(Request $request): Response
    {
        $Reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $Reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Reservation);
            $entityManager->flush();

            return $this->redirectToRoute('affiche8');
        }

        return $this->render('Reservation/New.html.twig', [
            'Reservation' => $Reservation,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @param Request $request
     * @param Reservation $Reservation
     * @return Response
     * @Route ("Reservation/edit/{id}",name="editt")
     */

     function Update(ReservationRepository $repository,$id,Request $request)
    {
        $Reservation= $repository->find($id);
        $form = $this->createForm(ReservationType::class, $Reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editt');
        }

        return $this->render('Reservation/edit.html.twig', [
            'Reservation' => $Reservation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @param $id
     * @param ReservationRepository $rep
     * @Route ("/Delete/{id}", name="de")
     */

    function Delete($id,ReservationRepository $rep){
        $Reservation=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Reservation);
        $em->flush();
        return $this->redirectToRoute('affiche8');

    }
}



