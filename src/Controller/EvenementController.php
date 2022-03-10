<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }
    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/affichek", name="affichek")
     */
    function Affiche( ){
        $repo=$this->getDoctrine()->getRepository(Evenement::class);

        $evenement=$repo->findAll();


        return $this->render('evenement/index.html.twig',
            [
                'Evenement'=>$evenement,

            ]);


    }





    /**
     * @param Request $request
     * @param EvenementRepository $repository
    
     * @return Response
     * @Route ("/add", name="add")
     */
    public function Add(Request $request , EvenementRepository $repository ): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image')->getData();
          //  $evenement->setRestaurant($Restaurant);;
               $uploads_directory = $this->getParameter(  'uploads_directory')   ;
            $filename = $evenement->getImage() . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            // On stocke l'image dans la base de données (son nom)
            $evenement->setImage($filename);
            $evenement->setNomImage($filename);


           
           // $evenement->setCreatedAt(new \DateTime());



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('affichek');
        }

        return $this->render('Evenement/Newevent.html.twig', [
            'Evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @param $id
     * @param Request $request
     * @Route ("Evenement/edit/{id}",name="edit")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    function Update(EvenementRepository $repository,$id,Request $request)
    {
        $evenement = $repository->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affichek');
        }

        return $this->render('Evenement/editE.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @param EvenementRepository $rep
     * @Route ("/Delete/{id}", name="delete")
     */
    function Delete($id,EvenementRepository $rep){
        $evenement=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('affichek');


    }

    /**
     * @param $name
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function indexx($name, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'Evenement/registration.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                    'Evenement/registration.txt.twig',
                    ['name' => $name]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

        return $this->redirectToRoute('affichek');



    }






}
