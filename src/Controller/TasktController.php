<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AssetTypeFormType;
use App\Form\FromInctFormType;
use App\Form\HostnameFormType;
use App\Form\NewUserType;
use App\Form\TypeFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * @Route("/taskt", name="taskt_")
 */
class TasktController extends AbstractController
{

    /**
     * @Route("/from-inct", name="from_inct")
     */
    public function fromInct(Request $request, EntityManagerInterface $em): Response
    {
        $survey = $this->getUser()->getSurvey();
        $form = $this->createForm(FromInctFormType::class);
        $form->handleRequest($request);
        $from_inct = $form->get('from_inct')->getData();
        if ($form->isSubmitted() && $form->isValid()){
            if ($from_inct == 'Non'){
                $survey->setFromInct('Non');
            }else{
                $survey->setFromInct('Oui');
            }
            $em->persist($survey);
            $em->flush();
            return $this->redirectToRoute("taskt_asset_type",  [
            ]);

        }
        return $this->render('Survey/Taskt/from_inct_field.html.twig', [
            'form' => $form->createView(),
        ]);
    }





























//
//    /**
//     * @Route("/from-inct", name="from_inct")
//     */
//    public function fromInct(Request $request, EntityManagerInterface $em): Response
//    {
//        $survey = $this->getUser()->getSurvey();
//        $form = $this->createForm(FromInctFormType::class);
//        $form->handleRequest($request);
//        $from_inct = $form->get('from_inct')->getData();
//        if ($form->isSubmitted() && $form->isValid()){
//            if ($from_inct == 'Non'){
//                $survey->setFromInct('Non');
//            }else{
//                $survey->setFromInct('Oui');
//            }
//            $em->persist($survey);
//            $em->flush();
//            return $this->redirectToRoute("taskt_asset_type",  [
//            ]);
//
//        }
//        return $this->render('Survey/Taskt/from_inct_field.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }
//
//
//    /**
//     * @Route("/type-asset", name="asset_type")
//     */
//    public function setAssetType(Request $request, EntityManagerInterface $em): Response
//    {
//        $survey = $this->getUser()->getSurvey();
//        $form = $this->createForm(AssetTypeFormType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()){
//            $assetType = $form->get("assetType")->getData();
//            $survey->setAssetType($assetType);
//            $em->persist($survey);
//            $em->flush();
//            if ( $assetType == "Autre" ) {
//                return $this->redirectToRoute("description",[
//                    'survey' => $survey,
//                ]);
//            }elseif ( ($assetType == 'Desktop') || ($assetType == 'Laptop') ){
//                return $this->redirectToRoute("taskt_hostname",[
//                    'survey' => $survey,
//                ]);
//            }
//
//        }
//        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
//            'asset_type_field_form' => $form->createView(),
//
//        ]);
//    }
//
//
//
//
//    /**
//     * @Route("/taskt-type", name="type_taskt")
//     */
//    public function typeIntervention($from_inct, $asset_type, Request $request): Response
//    {
//        $form = $this->createForm(TypeFormType::class);
//        $form->handleRequest($request);
////        $previousUrl = $request->headers->get('referer');
//        if ($form->isSubmitted() && $form->isValid()){
//            $intervention = $form->get('type')->getData();
//            if ( ($intervention == 'Dotation') || ($intervention == 'Prêt') ){
//                return $this->redirectToRoute('taskt_new_user',[
//                    'from_inct' => $from_inct,
//                    'asset_type' => $asset_type,
//                    'intervention' => $intervention,
//                ]);
//            }elseif( ($intervention == "Restitution")){
//                return $this->redirectToRoute('taskt_hostname',[
//                    'from_inct' => $from_inct,
//                    'asset_type' => $asset_type,
//                    'intervention' => $intervention,
//                    'new_user' => 'skipped',
//                ]);
//            }elseif( ($intervention == "Renouvellement")){
//                return $this->redirectToRoute('taskt_hostname',[
//                    'from_inct' => $from_inct,
//                    'asset_type' => $asset_type,
//                    'intervention' => $intervention,
//                    'new_user' => 'skipped',
//                ]);
//            }
//        }
//        return $this->render('Survey/Taskt/type_field.html.twig', [
//            'form' => $form->createView(),
//            'from_inct' => $from_inct,
//            'asset_type' => $asset_type,
////            'previous_url' => $previousUrl,
//        ]);
//    }
//
//
//
//    /**
//     * @Route("/new-user", name="new_user")
//     */
//    public function newUser($from_inct, $asset_type, $intervention, Request $request): Response
//    {
//        $form = $this->createForm(NewUserType::class);
//        $form->handleRequest($request);
////        $previousUrl = $request->headers->get('referer');
//
//        if ($form->isSubmitted() && $form->isValid()){
//            $newUser = $form->get('new_user')->getData();
//            return $this->redirectToRoute('taskt_hostname',[
//                'from_inct' => $from_inct,
//                'asset_type' => $asset_type,
//                'new_user' => $newUser,
//                'intervention' => $intervention,
//            ]);
//
//        }
//        return $this->render('Survey/Taskt/new_user.html.twig', [
//            'form' => $form->createView(),
//            'from_inct' => $from_inct,
//            'asset_type' => $asset_type,
//            'intervention' => $intervention,
////            'previous_url' => $previousUrl,
//        ]);
//    }
//
//
//    /**
//     * @Route("/hostname", name="hostname")
//     */
//    public function hostname(Request $request, EntityManagerInterface $em): Response
//    {
//        $form = $this->createForm(HostnameFormType::class);
//        $form->handleRequest($request);
//
//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////       GESTION FICHIER CSV         //////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
/////
//        //////////////////         EN LOCAL HOST          //////////////////
//        $csv = '../assets/csv/postes.csv';
//        //////////////////         EN SERVEUR PROD        //////////////////
////        $csv = '/home/scctcrvc/public_html/scc-tool/assets/csv/postes.csv';
//        $arrayCsv = file($csv);
////        $file = fopen($csv, 'r');
//
//        foreach ($arrayCsv as $key => $item){
//            if ($item && ($key != 0)){
//                $item = substr($item, 0, -2);
//                $item = explode(';',$item);
////                $id = $item[0];
//                $assetName = $item[1];
//                $hostnames[] = $assetName;
//            }
//        }
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//
//
//        if ($form->isSubmitted() && $form->isValid()){
//
//            $survey = $this->getUser()->getSurvey();
//            $hostname = $_POST["hostname"];
//            $customHostname = $form->get('customHostname')->getData();
//
//            if ($hostname && !$customHostname){
//                $survey->setHostname($hostname);
//            }elseif($customHostname){
//                $survey->setHostname($customHostname);
//            }elseif (!$hostname && !$customHostname){
//                $this->addFlash('info', 'Veuillez indiquer un hostname pour continuer');
//                return $this->redirectToRoute("taskt_hostname");
//            }
//            $em->persist($survey);
//            $em->flush();
//            return $this->redirectToRoute("description");
//        }
//
//        return $this->render('Survey/hostname.html.twig', [
//            'hostname_field_form' => $form->createView(),
//            'assets' => $hostnames,
//        ]);
//    }

}
