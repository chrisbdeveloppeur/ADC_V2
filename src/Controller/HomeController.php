<?php

namespace App\Controller;



use App\Entity\Asset;
use App\Entity\Survey;
use App\Form\AssetsType;
use App\Form\AssetType;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\ServiceType;
use App\Form\TypeFormType;
use App\Form\TypeInterTasktForm;
use App\Form\TypeInterInctForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * Class HomeController
// * @package App\Controller
// * @IsGranted("ROLE_USER")
// */

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
            return $this->redirectToRoute('q1',[
                'service' => $reponse,
            ]);
        }

        return $this->render('Survey/home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/service", name="q1")
     */
    public function tasktOrInct(Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $reponse = $form->get('choices')->getData();
            $survey->setType($reponse);
            return $this->redirectToRoute('q2');
        }
        return $this->render('Survey/sdp/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
        ]);
    }

    /**
     * @Route("/type", name="q2")
     */
    public function typeInter(Request $request)
    {
        $survey = $this->get('session')->get('survey');
        $type = $survey->getType();
        if ($type == "inct"){
            $form = $this->createForm(TypeInterInctForm::class);
        }elseif ($type == 'taskt'){
            $form = $this->createForm(TypeInterTasktForm::class);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $reponse = $form->get('choices')->getData();
            $survey->setTypeInter($reponse);
            if ($reponse == 'inct_1'){         /* Changement de PC */
                return $this->redirectToRoute('asset_form',[
                    'reponse' => $reponse,
                ]);
            }elseif ($reponse == 'inct_2' ){   /* Autre intervention matérielle */
                return $this->redirectToRoute('q2');
            }elseif($reponse == 'inct_3'){                      /* Intervention software */
                return $this->redirectToRoute('q2',[
                    'tasktorinct' => $reponse,
                ]);
            }

        }

        return $this->render('Survey/sdp/type_inter.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
        ]);

    }





    /**
     * @Route("/asset-form", name="asset_form")
     */
    public function assetForm(Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $form = $this->createForm(AssetsType::class);
        $assetForm = $this->createForm(AssetType::class);
        $form->handleRequest($request);
        $assetForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getAssets()); $i++ ){
            $number = $i;
        }

        if ($assetForm->isSubmitted() && $number<=10){
            $newAsset = new Asset();
            $newAsset->setSurvey($survey);
            $newAsset->setPosition($number);
            $newAsset->setCurrentHostname($assetForm->get('as')->getData());
            $newAsset->setNewHostname($assetForm->get('ae')->getData());
            $newAsset->setType($assetForm->get('type')->getData());
            $newAsset->setAction($assetForm->get('action')->getData());
            if ( ($newAsset->getAction()=="DEM_PDT") || ($newAsset->getAction()=="PRT_PCF") ){
                $newAsset->setType(null);
            }
            $newAsset->setRspd($assetForm->get('rspd')->getData());
            $newAsset->setDuree($assetForm->get('tpx')->getData());
            if ($newAsset->getNewHostname()==null){
                $newAsset->setNewHostname('n/a');
            }
            if ($newAsset->getCurrentHostname()==null){
                $newAsset->setCurrentHostname('n/a');
            }
            $survey->addAsset($newAsset);
        }

        if ($form->isSubmitted()){
            dump($survey);
            die();
        }

        return $this->render('Survey/assets_form.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'asset_form' => $assetForm->createView(),
            'survey' => $survey,
        ]);
    }


    /**
     * @Route("/del-asset={position}", name="del_asset")
     */
    public function delAsset($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
//        dd($survey);
        $assetToDelete = $survey->getAssets()[$position];
        unset($survey->getAssets()[$position]);
        $form = $this->createForm(AssetsType::class);
        $form->handleRequest($request);

//        $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//        return $this->redirect($referer);
        return $this->json('asset ' . $assetToDelete . ' retiré !');

    }






    /**
     * @Route("/description", name="description")
     */
    public function description(Request $request, EntityManagerInterface $em): Response
    {
        $survey = $this->getUser()->getSurvey();
        $form = $this->createForm(DescriptionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                $infos = $form->get('infos')->getData();
                $survey->setDescription($infos);
                $em->persist($survey);
                $em->flush();
                return $this->redirectToRoute("final_string");

        }
        return $this->render('Survey/description_form.html.twig',[
            'description_form' => $form->createView(),
        ]);
    }




    public function miseEnForm($text, $info){
        if ( ($text == 'skipped') || ($text == '') || ($text == ' ') ){
            return $text = null;
        }else{
            $text = $info . $text;
            return $text . "\r\n";
        }
    }
    /**
     * @Route("/validation", name="final_string")
     * @IsGranted("ROLE_USER")
     */
    public function stringGen(): Response
    {
        $survey = $this->getUser()->getSurvey();
        $textDescription = $survey->getDescription();
        $text = preg_replace('/\s\s+/', ' ', $textDescription);

        $from_inct = $this->miseEnForm($survey->getFromInct(), 'Suite à incident : ');
        $asset_type = $this->miseEnForm($survey->getAssetType(), 'Type de matériel : ');
        $new_user = $this->miseEnForm($survey->getNewUser(),'Nouvel arrivant : ');
        $hostname = $this->miseEnForm($survey->getHostname(),'Hostname : ');
        $intervention = $this->miseEnForm($survey->getType(),'Type d\'intervention : ');
        $description = $this->miseEnForm($survey->getDescription(), 'Déscription : ');

        $finalString = [$from_inct, $asset_type, $new_user, $hostname, $intervention, $description] ;
        foreach ($finalString as $key => $value){
            if ($value == null){
                unset($finalString[$key]);
            }
        }
        $finalString = implode($finalString);

        $survey = new Survey();
//         Hashage (crc32) de la chaine final
        $survey->setHashedString($finalString);
        $date = $survey->getDateString();
        $date = $date->format('d/m/Y - H:i');
        $finalString .= "[" . $date . "]";
        $finalString .= "\r\n[" . $survey->getHashedString() . "]";

        $survey->setFinalString($finalString);

        $form = $this->createForm(FinalStringFormType::class, $survey);
        return $this->render('Survey/final_string_form.html.twig', [
            'final_string_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
            'intervention' => $intervention,
            'new_user' => $new_user,
            'hostname' => $hostname,
            'final_string' => $finalString,
        ]);
    }



}
