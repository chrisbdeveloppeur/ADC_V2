<?php

namespace App\Controller;

use App\Entity\Survey;
use App\Form\ResolveMethodType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use App\Form\UserCmdbDifType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
/*
 * Le HomeController.php contient la logique des premières questions de l'arbre de clôture v2. Ce sont les questions plaçant le contexte de la demande ou l'incident.
 * A chaque validation d'un formulaire (lorsque l'on valide une question), l'entité Survey.php est mise à jour. Elle contient toutes les données que l'utilisateur ajoutera au fur et à mesure.
 *
 * La route home : page d'accueil avec le choix du service SDP ou HD, ce controller sert à définir la variable "service" de l'entité Survey
 * La route methode : sert à définir la variable "resolve_method" de l'entité Survey, correspondant à la méthode d'intervention, exemples = PMAD ou Plateau
 * La route tasktorinct : sert à définir la variable "type" de l'entité Survey. Si l'on est dans le cas d'une demande = DEM ou d'un incident = INC  (Cette route sautée si service HD selectionné au préalable)
 * La route user_cmdb_dif : sert à définir la variable "user_cmdb_dif" de l'entité Survey. : /!\ ATTENTION : la valeur NON signifie que l'utilisateur de la DEM/INC ne correspond pas !
 *
 * */
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
        $survey =  $surveySessionController->checkSurveySession();
        $survey->setResolveMethod(null);
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ResolveMethodType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $method = $form->get('method')->getData();
            $survey->setResolveMethod($method);
            $service = $survey->getService();
            if ($service == 'HD'){
                $survey->setType('DEM');
                return $this->redirectToRoute('user_cmdb_dif');
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
        $survey =  $surveySessionController->checkSurveySession();
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

        $survey->setType(null);
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $reponse = $form->get('type')->getData();
            $survey->setType($reponse);
            return $this->redirectToRoute('user_cmdb_dif');
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/home/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }




    /**
     * @Route("/user-cmdb-dif", name="user_cmdb_dif")
     */
    public function userCmdbDif(Request $request, CheminController $cheminController, SurveySessionController $surveySessionController)
    {
        $survey =  $surveySessionController->checkSurveySession();
        if ($survey == null){
            $this->addFlash('danger', 'Votre session à expiré !');
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(UserCmdbDifType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $reponse = $form->get('user_cmdb_dif')->getData();
            $survey->setUserCmdbDif($reponse);
//            dd($survey);
            if ($survey->getType() == 'INC'){
                if ($survey->getResolveMethod() == 'PMAD'){
                    return $this->redirectToRoute('rdv');
                }else{
                    return $this->redirectToRoute('inct_home', [
                    ]);
                }
            }else{
                return $this->redirectToRoute('taskt_home', [
                ]);
            }
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/home/user_cmdb_dif.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'survey' => $survey,
        ]);
    }




}
