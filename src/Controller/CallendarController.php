<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CallendarController extends AbstractController
{
    /**
     * @Route("/0", name="calendar_index")
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouterE")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="afficher_un")
     */
    public function show(Calendar $calendar): Response
    {
        return $this->render('calendar/show.html.twig', [
            'calendar' => $calendar,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="modifier")
     */
    public function edit($id, Request $request, CalendarRepository $rep)
    {
        $calendar = $rep->find($id);

        $form1 = $this->createForm(CalendarType::class, $calendar);
        $form1->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if (($form1->isSubmitted() && $form1->isValid())) {

            $em->persist($calendar);

            $em->flush();
            $this->addFlash('notice', 'Evenement modifie avec succée !');
            return $this->redirectToRoute("main");
        }
        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form1->createView(),
        ]);

    }
    /**
     * @Route("/{id}/supp", name="supprimer")
     */
    public function supprimer($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $Calendar = $entityManager->getRepository(Calendar::class)->find($id);
        $entityManager->remove($Calendar);
        $this->addFlash('success', 'Evenement supprimée.');


        $entityManager->flush();
        return $this->redirectToRoute('main');


    }



}
