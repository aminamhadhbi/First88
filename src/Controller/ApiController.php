<?php

namespace App\Controller;

use App\Entity\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use DateTime;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/{id}/edit", name="api_event_edit",methods={"PUT"})

     */
    public function majEvent(?Calendar $calendar,Request $request)
    {
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor)
        )
        {
            $code = 200;
            if(!$calendar){
                $calendar = new Calendar;
                $code=201;
            }
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            $calendar->setBorderColor($donnees->borderColor);
            if($donnees->allDay){
                $calendar->setEnd(new DateTime($donnees->start));
            }else{
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->allDay);
            $calendar->setBorderColor($donnees->borderColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            return $this->render('api/index.html.twig', [
                'controller_name' => 'ApiController',
            ]);

    }


}}
