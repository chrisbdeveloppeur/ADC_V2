<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Form\AssetsType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $survey = new Survey();

        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);
        $this->get('session')->set('survey', $survey);
        if ($form->isSubmitted()){
            $reponse = $form->get('service')->getData();
            $survey->setService($reponse);
            if ($reponse == 'HD'){
                $survey->setType('DEM');
                return $this->redirectToRoute('taskt_home',[
                    'service' => $reponse,
                ]);
            }elseif ($reponse == 'SDP'){
                return $this->redirectToRoute('tasktorinct',[
                    'service' => $reponse,
                ]);
            }
        }

        return $this->render('Survey/home/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/taskt-or-inct", name="tasktorinct")
     */
    public function tasktOrInct(Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $survey->setType(null);
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $reponse = $form->get('type')->getData();
            $survey->setType($reponse);
            if ($reponse == 'DEM'){
                return $this->redirectToRoute('taskt_home', [
                ]);
            }elseif ($reponse == 'INC'){
                return $this->redirectToRoute('inct_home', [
                ]);
            }
        }
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }




}
