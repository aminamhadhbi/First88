<?php

namespace App\Controller;

use App\Repository\CalendarRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainCallController extends AbstractController
{

    /**
     * @Route("/", name="main")
     */
    public function index(CalendarRepository $calendarRepository)
    {
        $events = $calendarRepository->findAll();

        //dd($events);
        //dd($calls);
        /* $alldata= $calendarRepository->GetAllData();
         dd($alldata);*/
        $appel=[];
        $rdvs=[];
        foreach ($events as $event){
            $rdvs[]=[
                'id'=>$event->getId(),
                'start'=>$event->getStart()->format('Y-m-d H:i:s'),
                'end'=>$event->getEnd()->format('Y-m-d H:i:s'),
                'title'=>$event->getTitle(),
                'description'=>$event->getDescription(),
                'borderColor'=>$event->getBorderColor(),
                'allDay'=>$event->getAllDay(),
            ];
        }

       // foreach ($calls as $call){
         //   $appel[]=[
           //     'idcall'=>$call->getId(),
             //   'startdate'=>$call->getStartDate()->format('Y-m-d H:i:s'),
              //  'enddate'=>$call->getEndDate()->format('Y-m-d H:i:s'),
               // 'members'=>$call->getMembers(),
            //];
       // }

        $data = json_encode($rdvs);
     //   $Callz = json_encode($appel);
        //dd($Callz);
        return $this->render('main_call/index.html.twig', [
            'data'=>$data
       //     'calls'=>$Callz
        ]);
    }
}
