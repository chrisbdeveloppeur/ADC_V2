<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Asset;
use App\Entity\OtherAction;
use App\Entity\OtherApp;
use App\Entity\OtherAsset;
use App\Form\AppType;
use App\Form\AssetType;
use App\Form\DescriptionFormType;
use App\Form\GlobalFormType;
use App\Form\OtherAppType;
use App\Form\OtherAssetType;
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

        if ( $assetForm->isSubmitted() && $number<=10 ){

            if ($assetForm->get('action')->getData()){
                $newAsset = new Asset();
                $newAsset->setSurvey($survey);
                $newAsset->setPosition($number);
                $newAsset->setAs($assetForm->get('as')->getData());
                $newAsset->setAe($assetForm->get('ae')->getData());
                $newAsset->setType($assetForm->get('type')->getData());
                $newAsset->setAction($assetForm->get('action')->getData());
                if ( ($newAsset->getAction()=="DEM") || ($newAsset->getAction()=="REP") ){
                    $newAsset->setType("PDT");
                }
                $newAsset->setRsdp($assetForm->get('rsdp')->getData());
                $newAsset->setTpx($assetForm->get('tpx')->getData());
                if ($newAsset->getAe()==null){
                    $newAsset->setAe('N/A');
                }
                if ($newAsset->getAs()==null){
                    $newAsset->setAs('N/A');
                }
                if ($newAsset->getType()==null){
                    $newAsset->setType('XX');
                }
                $survey->addAsset($newAsset);
                $action = $newAsset->getAction();
                $type = $newAsset->getType();
                $newAsset->setBalise($action . '_' . $type);
                $ae = $newAsset->getAe();
                $as = $newAsset->getAs();
                $urlForDelete = $this->redirectToRoute('form_asset_del',[
                    'position' => $number,
                ]);
            }

            if ($assetForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
            }else{
//                if ($survey->getCas()== 'SDP_INC_1'){
                    return $this->redirectToRoute('form_other_asset');
//                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()){
//            if ($survey->getCas()== 'SDP_INC_1'){
//                return $this->redirectToRoute('form_other_asset');
//            }
//            elseif ($survey->getCas()== 'SDP_INC_2'){
//                return $this->redirectToRoute('form_other_asset');
//            }elseif ($survey->getCas()== 'SDP_INC_3'){
                return $this->redirectToRoute('form_other_asset');
//            }

        }

        return $this->render('Survey/forms/assets_form.html.twig',[
            'form' => $form->createView(),
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

            if ($otherAssetForm->get('action')->getData()){
                $newAsset = new OtherAsset();
                $newAsset->setSurvey($survey);
                $newAsset->setPosition($number);
                $newAsset->setAs($otherAssetForm->get('as')->getData());
                $newAsset->setAe($otherAssetForm->get('ae')->getData());
                $newAsset->setType($otherAssetForm->get('type')->getData());
                $newAsset->setAction($otherAssetForm->get('action')->getData());
                if ( ($newAsset->getAction()=="PRT") || ($newAsset->getAction()=="REN") ){
                    $newAsset->setType('PHN');
                }
                $newAsset->setRsdp($otherAssetForm->get('rsdp')->getData());
                $newAsset->setTpx($otherAssetForm->get('tpx')->getData());
                if ($newAsset->getAe()==null){
                    $newAsset->setAe('N/A');
                }
                if ($newAsset->getAs()==null){
                    $newAsset->setAs('N/A');
                }
                if ($newAsset->getType()==null){
                    $newAsset->setType('XX');
                }
                $survey->addOtherAsset($newAsset);

                $action = $newAsset->getAction();
                $type = $newAsset->getType();
                $newAsset->setBalise($action . '_' . $type);
                $ae = $newAsset->getAe();
                $as = $newAsset->getAs();
                $urlForDelete = $this->redirectToRoute('form_asset_del',[
                    'position' => $number,
                ]);
            }

            if ($otherAssetForm->get('multiple')->getData() === true){
                return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
            }else{
                if ($survey->getCas()== 'SDP_INC_1'){
                    return $this->redirectToRoute('form_app');
                }else{
                    return $this->redirectToRoute('form_commentaire');
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas()== 'SDP_INC_1'){
                return $this->redirectToRoute('form_app');
            }else{
                return $this->redirectToRoute('form_commentaire');
            }
//            return $this->redirectToRoute();
        }

        return $this->render('Survey/forms/other_assets_form.html.twig',[
            'form' => $form->createView(),
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
        unset($survey->getOtherAssets()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('asset ' . $otherAssetToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////












//////////////////////////////  OTHER_ACTION FORM  //////////////////////////////
    /**
     * @Route("/autre-action", name="other_action")
     */
    public function otherActionForm(Request $request): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $otherActionForm = $this->createForm(OtherAssetType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $otherActionForm->handleRequest($request);

//        Vérification du nombre d'actions déjà présentes dans le formulaire
        for ($i=0; $i<=count($survey->getOtherAactions()); $i++ ){
            $number = $i;
        }

        if ($otherActionForm->isSubmitted() && $number<=10){

            if ($otherActionForm->get('action')->getData()){
                $newAsset = new OtherAction();
                $newAsset->setSurvey($survey);
                $newAsset->setPosition($number);
                $newAsset->setAsset($otherActionForm->get('as')->getData());
                $newAsset->setAction($otherActionForm->get('action')->getData());
                $newAsset->setRsdp($otherActionForm->get('rsdp')->getData());
                $newAsset->setTpx($otherActionForm->get('tpx')->getData());
                if ($newAsset->getAsset()==null){
                    $newAsset->setAsset('N/A');
                }
                $survey->addOtherAction($newAsset);

                $action = $newAsset->getAction();
                $newAsset->setBalise($action);
                $asset = $newAsset->getAsset();
                $urlForDelete = $this->redirectToRoute('form_other_action_del',[
                    'position' => $number,
                ]);
            }

            if ($otherActionForm->get('multiple')->getData() === true){
                return $this->json(['action' => $action,'ae' => $ae,'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
            }else{
                if ($survey->getCas() == 'SDP_DEM_4' || $survey->getCas() == 'HD_DEM_4'){
                    return $this->redirectToRoute('form_commentaire');
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() == 'SDP_DEM_4' || $survey->getCas() == 'HD_DEM_4'){
                return $this->redirectToRoute('form_commentaire');
            }
        }

        return $this->render('Survey/forms/other_assets_form.html.twig',[
            'form' => $form->createView(),
            'other_asset_form' => $otherActionForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-other-action={position}", name="other_action_del")
     */
    public function delOtherAction($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $otherAssetToDelete = $survey->getOtherAssets()[$position];
        unset($survey->getOtherAssets()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

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
        $appForm = $this->createForm(AppType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $appForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getApps()); $i++ ){
            $number = $i;
        }

//
        if ($appForm->isSubmitted() && $number<=10){

            if ($appForm->get('action')->getData()){
                $app = new App();
                $app->setSurvey($survey);
                $app->setPosition($number);
                $app->setAsset($appForm->get('asset')->getData());
                $app->setAction($appForm->get('action')->getData());
                $app->setRsdp($appForm->get('rsdp')->getData());
                $app->setTpx($appForm->get('tpx')->getData());
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
            }

            if ($appForm->get('multiple')->getData() === true){
                return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
            }else{
                if ($survey->getCas() === 'SDP_INC_1'){
                    return $this->redirectToRoute('form_commentaire');
                }else{
                    return $this->redirectToRoute('form_other_app');
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() === 'SDP_INC_3'){
                return $this->redirectToRoute('form_other_app');

            }else{
                return $this->redirectToRoute('form_commentaire');
            }
        }

        return $this->render('Survey/forms/apps_form.html.twig',[
            'form' => $form->createView(),
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

        return $this->json('app ' . $appToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////







//////////////////////////////  OTHER APP FORM  //////////////////////////////
    /**
     * @Route("/action-logiciel", name="other_app")
     */
    public function otherAppForm(Request $request): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $otherAppForm = $this->createForm(OtherAppType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $otherAppForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getOtherApps()); $i++ ){
            $number = $i;
        }

//
        if ($otherAppForm->isSubmitted() && $number<=10){

            if ($otherAppForm->get('action')->getData()){
                $otherApp = new OtherApp();
                $otherApp->setSurvey($survey);
                $otherApp->setPosition($number);
                $otherApp->setAsset($otherAppForm->get('asset')->getData());
                $otherApp->setAction($otherAppForm->get('action')->getData());
                $otherApp->setRsdp($otherAppForm->get('rsdp')->getData());
                $otherApp->setTpx($otherAppForm->get('tpx')->getData());
                if ($otherApp->getAsset()==null){
                    $otherApp->setAsset('N/A');
                }
                $survey->addApp($otherApp);

                $action = $otherApp->getAction();
                $otherApp->setBalise($action);
                $asset = $otherApp->getAsset();
                $urlForDelete = $this->redirectToRoute('form_app_del',[
                    'position' => $number,
                ]);
            }

            if ($otherAppForm->get('multiple')->getData() === true){
                return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
            }else{
                if ($survey->getCas() === 'SDP_INC_1'){
                    return $this->redirectToRoute('form_commentaire');
                }elseif ($survey->getCas() === 'SDP_INC_3'){
//                return $this->redirectToRoute('form_other_app');
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() === 'SDP_INC_1'){
                return $this->redirectToRoute('form_commentaire');
            }elseif ($survey->getCas() === 'SDP_INC_3'){
//                return $this->redirectToRoute('form_other_app');
            }
        }

        return $this->render('Survey/forms/other_apps_form.html.twig',[
            'form' => $form->createView(),
            'other_app_form' => $otherAppForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-other-app={position}", name="other_app_del")
     */
    public function delOtherApp($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $appToDelete = $survey->getOtherApps()[$position];
        unset($survey->getOtherApps()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('app ' . $appToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////












    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function description(Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $commentaireForm = $this->createForm(DescriptionFormType::class);
        $commentaireForm->handleRequest($request);

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()){
            $commentaire = $commentaireForm->get('commentaire')->getData();
            $survey->setCommentaire($commentaire);
            return $this->redirectToRoute("final_string");
        }
        return $this->render('Survey/forms/description_form.html.twig',[
            'commentaire_form' => $commentaireForm->createView(),
        ]);
    }



}
