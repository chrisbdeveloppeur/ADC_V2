<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Asset;
use App\Entity\OtherAsset;
use App\Form\AppsType;
use App\Form\AssetType;
use App\Form\DescriptionFormType;
use App\Form\GlobalFormType;
use App\Form\OtherAssetType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/form", name="form_")
 *
 */

class FormsController extends AbstractController
{
//////////////////////////////  ASSET FORM  //////////////////////////////
    /**
     * @Route("/poste-de-travail", name="asset")
     */
    public function assetForm(Request $request): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $assetForm = $this->createForm(AssetType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $assetForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getAssets()); $i++ ){
            $number = $i;
        }
//
        if ($assetForm->isSubmitted() && $number<=10){
            $newAsset = new Asset();
            $newAsset->setSurvey($survey);
            $newAsset->setPosition($number);
            $newAsset->setCurrentHostname($assetForm->get('as')->getData());
            $newAsset->setNewHostname($assetForm->get('ae')->getData());
            $newAsset->setType($assetForm->get('type')->getData());
            $newAsset->setAction($assetForm->get('action')->getData());
            if ( ($newAsset->getAction()=="DEM") || ($newAsset->getAction()=="REP") ){
                $newAsset->setType("PDT");
            }
            $newAsset->setRsdp($assetForm->get('rsdp')->getData());
            $newAsset->setTpx($assetForm->get('tpx')->getData());
            if ($newAsset->getNewHostname()==null){
                $newAsset->setNewHostname('N/A');
            }
            if ($newAsset->getCurrentHostname()==null){
                $newAsset->setCurrentHostname('N/A');
            }
            $survey->addAsset($newAsset);
            $action = $newAsset->getAction();
            $type = $newAsset->getType();
            $newAsset->setBalise($action . '_' . $type);
            $ae = $newAsset->getNewHostname();
            $as = $newAsset->getCurrentHostname();
            $urlForDelete = $this->redirectToRoute('form_asset_del',[
                'position' => $number,
            ]);


//            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//            return $this->redirect($referer);
            return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
        }

        if ($form->isSubmitted() && $form->isValid()){
//            dd($survey);
            if ($survey->getCas()== 'SDP_INC_1'){
                return $this->redirectToRoute('form_other_asset');
            }
//            elseif ($survey->getCas()== 'SDP_INC_2'){
//                return $this->redirectToRoute('form_other_asset');
//            }elseif ($survey->getCas()== 'SDP_INC_3'){
//                return $this->redirectToRoute('form_other_asset');
//            }

        }

        return $this->render('Survey/forms/assets_form.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'asset_form' => $assetForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-asset={position}", name="asset_del")
     */
    public function delAsset($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $assetToDelete = $survey->getAssets()[$position];
        unset($survey->getAssets()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

//        $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//        return $this->redirect($referer);
        return $this->json('asset ' . $assetToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////








//////////////////////////////  OTHER_ASSET FORM  //////////////////////////////
    /**
     * @Route("/autre-materiel", name="other_asset")
     */
    public function otherAssetForm(Request $request): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $otherAssetForm = $this->createForm(OtherAssetType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $otherAssetForm->handleRequest($request);

//        Vérification du nombre d'actions déjà présentes dans le formulaire
        for ($i=0; $i<=count($survey->getOtherAssets()); $i++ ){
            $number = $i;
        }

        if ($otherAssetForm->isSubmitted() && $number<=10){
            $newAsset = new OtherAsset();
            $newAsset->setSurvey($survey);
            $newAsset->setPosition($number);
            $newAsset->setCurrentHostname($otherAssetForm->get('as')->getData());
            $newAsset->setNewHostname($otherAssetForm->get('ae')->getData());
            $newAsset->setType($otherAssetForm->get('type')->getData());
            $newAsset->setAction($otherAssetForm->get('action')->getData());
            if ( ($newAsset->getAction()=="PRT") || ($newAsset->getAction()=="REN") ){
                $newAsset->setType('PHN');
            }
            $newAsset->setRsdp($otherAssetForm->get('rsdp')->getData());
            $newAsset->setTpx($otherAssetForm->get('tpx')->getData());
            if ($newAsset->getNewHostname()==null){
                $newAsset->setNewHostname('N/A');
            }
            if ($newAsset->getCurrentHostname()==null){
                $newAsset->setCurrentHostname('N/A');
            }
            $survey->addOtherAsset($newAsset);

            $action = $newAsset->getAction();
            $type = $newAsset->getType();
            $newAsset->setBalise($action . '_' . $type);
            $ae = $newAsset->getNewHostname();
            $as = $newAsset->getCurrentHostname();
            $urlForDelete = $this->redirectToRoute('form_asset_del',[
                'position' => $number,
            ]);

//            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//            return $this->redirect($referer);
            return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas()== 'SDP_INC_1'){
                return $this->redirectToRoute('form_app');
            }
//            return $this->redirectToRoute();
        }

        return $this->render('Survey/forms/other_assets_form.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'other_asset_form' => $otherAssetForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-other-asset={position}", name="other_asset_del")
     */
    public function delOtherAsset($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $otherAssetToDelete = $survey->getOtherAssets()[$position];
//        dd($survey, $position, $otherAssetToDelete);
        unset($survey->getOtherAssets()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

//        $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//        return $this->redirect($referer);
        return $this->json('asset ' . $otherAssetToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////








//////////////////////////////  APP FORM  //////////////////////////////
    /**
     * @Route("/application", name="app")
     */
    public function appForm(Request $request): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $appForm = $this->createForm(AppsType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $appForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getApps()); $i++ ){
            $number = $i;
        }

//
        if ($appForm->isSubmitted() && $number<=10){
            $app = new App();
            $app->setSurvey($survey);
            $app->setPosition($number);
            $app->setAsset($appForm->get('asset')->getData());
            $app->setAction($appForm->get('action')->getData());
            $app->setRsdp($appForm->get('rsdp')->getData());
            $app->setTpx($appForm->get('tpx')->getData());
//            if ( ($app->getAction()=="DEM") || ($app->getAction()=="REP") ){
//                $app->setType("PDT");
//            }
            if ($app->getAsset()==null){
                $app->setAsset('N/A');
            }
            $survey->addApp($app);

            $action = $app->getAction();
            $app->setBalise($action);
            $asset = $app->getAsset();
            $urlForDelete = $this->redirectToRoute('form_app_del',[
                'position' => $number,
            ]);

//            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//            return $this->redirect($referer);
            return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() === 'SDP_INC_1'){
                return $this->redirectToRoute('form_commentaire');
            }elseif ($survey->getCas() === 'SDP_INC_3'){
//                return $this->redirectToRoute('form_other_app');
            }
        }

        return $this->render('Survey/forms/apps_form.html.twig',[
            'form' => $form->createView(),
            'form_name' => $form->getName(),
            'app_form' => $appForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-app={position}", name="app_del")
     */
    public function delApp($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $appToDelete = $survey->getApps()[$position];
        unset($survey->getApps()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

//        $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//        return $this->redirect($referer);
        return $this->json('app ' . $appToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////











    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function description(Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
//        $form = $this->createForm(GlobalFormType::class);
        $commentaireForm = $this->createForm(DescriptionFormType::class);
//        $form->handleRequest($request);
        $commentaireForm->handleRequest($request);

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()){
            $commentaire = $commentaireForm->get('commentaire')->getData();
            $survey->setCommentaire($commentaire);
            return $this->redirectToRoute("final_string");
        }
        return $this->render('Survey/forms/description_form.html.twig',[
//            'form' => $form->createView(),
            'commentaire_form' => $commentaireForm->createView(),
        ]);
    }



}
