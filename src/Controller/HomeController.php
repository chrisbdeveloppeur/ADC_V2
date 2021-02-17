<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Form\ResolveMethodType;
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
    public function home(Request $request, CheminController $cheminController): Response
    {
        $survey = new Survey();
        $survey->setChemin(['/']);
        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);
        $this->get('session')->set('survey', $survey);
        if ($form->isSubmitted()){
            $reponse = $form->get('service')->getData();
            $survey->setService($reponse);
            return $this->redirectToRoute('method');
//            if ($reponse == 'HD'){
//                $survey->setType('DEM');
//                return $this->redirectToRoute('taskt_home');
//            }elseif ($reponse == 'SDP'){
//                return $this->redirectToRoute('tasktorinct');
//            }
        }

        $cheminController->setChemins($request);

        return $this->render('Survey/home/home.html.twig', [
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }


    /**
     * @Route("/methode", name="method")
     */
    public function method(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController)
    {
        $survey = $this->get('session')->get('survey');
        $surveySessionController->checkSurveySession($survey);

        $form = $this->createForm(ResolveMethodType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $method = $form->get('method')->getData();
            $survey->setResolveMethod($method);
            $service = $survey->getService();
            if ($service == 'HD'){
                $survey->setType('DEM');
                return $this->redirectToRoute('taskt_home');
            }elseif ($service == 'SDP'){
                return $this->redirectToRoute('tasktorinct');
            }
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/home/method.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }




    /**
     * @Route("/type", name="tasktorinct")
     */
    public function tasktOrInct(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController)
    {
        $survey = $this->get('session')->get('survey');
        $surveySessionController->checkSurveySession($survey);

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

        $cheminController->setChemins($request);
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }




}
