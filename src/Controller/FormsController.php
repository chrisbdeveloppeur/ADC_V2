<?php

namespace App\Controller;

use App\Entity\App;
use App\Entity\Asset;
use App\Entity\Cmdb;
use App\Entity\OtherAction;
use App\Entity\OtherApp;
use App\Entity\OtherAsset;
use App\Entity\Phone;
use App\Entity\Rdv;
use App\Form\AppType;
use App\Form\AssetType;
use App\Form\CmdbType;
use App\Form\DescriptionFormType;
use App\Form\GlobalFormType;
use App\Form\OtherActionType;
use App\Form\OtherAppType;
use App\Form\OtherAssetType;
use App\Form\PhoneType;
use App\Form\RdvType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

///**
// * @Route("/form", name="")
// */

class FormsController extends AbstractController
{
//////////////////////////////  ASSET FORM  //////////////////////////////
    /**
     * @Route("/ASSET-1", name="asset")
     */
    public function assetForm(Request $request, CheminController $cheminController): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $assetForm = $this->createForm(AssetType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $assetForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getAssets()); $i++ ){
            $number = $i;
        }

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
                    $newAsset->setAe('XX');
                }
                if ($newAsset->getAs()==null){
                    $newAsset->setAs('XX');
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
                $urlForDelete = $this->redirectToRoute('asset_del',[
                    'position' => $number,
                ]);

                if ($assetForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            return $this->redirectToRoute('other_asset');

        }

        if ($form->isSubmitted() && $form->isValid()){
                return $this->redirectToRoute('other_asset');
        }


        $cheminController->setChemins($request);
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
     * @Route("/ASSET-2", name="other_asset")
     */
    public function otherAssetForm(Request $request, CheminController $cheminController): Response
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
                    $newAsset->setAe('XX');
                }
                if ($newAsset->getAs()==null){
                    $newAsset->setAs('XX');
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
                $urlForDelete = $this->redirectToRoute('other_asset_del',[
                    'position' => $number,
                ]);
                if ($otherAssetForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            if ($survey->getCas()== 'SDP_INC_1' || $survey->getCas()== 'SDP_DEM_1' || $survey->getCas()== 'HD_DEM_1'){
                return $this->redirectToRoute('app');
            }else{
                return $this->redirectToRoute('rdv');
            }

        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas()== 'SDP_INC_1' || $survey->getCas()== 'SDP_DEM_1' || $survey->getCas()== 'HD_DEM_1'){
                return $this->redirectToRoute('app');
            }else{
                return $this->redirectToRoute('rdv');
            }
        }


        $cheminController->setChemins($request);
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
     * @Route("/AUTRE-ACTION-MATERIEL", name="other_action")
     */
    public function otherActionForm(Request $request, CheminController $cheminController): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $otherActionForm = $this->createForm(OtherActionType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $otherActionForm->handleRequest($request);

//        Vérification du nombre d'actions déjà présentes dans le formulaire
        for ($i=0; $i<=count($survey->getOtherActions()); $i++ ){
            $number = $i;
        }

        if ($otherActionForm->isSubmitted() && $number<=10){

            if ($otherActionForm->get('action')->getData()){
                $newAsset = new OtherAction();
                $newAsset->setSurvey($survey);
                $newAsset->setPosition($number);
                $newAsset->setAsset($otherActionForm->get('asset')->getData());
                $newAsset->setAction($otherActionForm->get('action')->getData());
                $newAsset->setRsdp($otherActionForm->get('rsdp')->getData());
                $newAsset->setTpx($otherActionForm->get('tpx')->getData());
                if ($newAsset->getAsset()==null){
                    $newAsset->setAsset('XX');
                }
                $survey->addOtherAction($newAsset);

                $action = $newAsset->getAction();
                $newAsset->setBalise($action);
                $asset = $newAsset->getAsset();
                $urlForDelete = $this->redirectToRoute('other_action_del',[
                    'position' => $number,
                ]);
                if ($otherActionForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            if ($survey->getCas() == 'SDP_DEM_4' || $survey->getCas() == 'HD_DEM_4'){
                return $this->redirectToRoute('rdv');
            }

        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() == 'SDP_DEM_4' || $survey->getCas() == 'HD_DEM_4'){
                return $this->redirectToRoute('rdv');
            }
        }


        $cheminController->setChemins($request);
        return $this->render('Survey/forms/other_actions_form.html.twig',[
            'form' => $form->createView(),
            'other_action_form' => $otherActionForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-other-action={position}", name="other_action_del")
     */
    public function delOtherAction($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $otherAssetToDelete = $survey->getOtherActions()[$position];
        unset($survey->getOtherActions()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('OtherAsset ' . $otherAssetToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////













//////////////////////////////  APP FORM  //////////////////////////////
    /**
     * @Route("/LOGICIEL", name="app")
     */
    public function appForm(Request $request, CheminController $cheminController): Response
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
                    $app->setAsset('XX');
                }
                $survey->addApp($app);

                $action = $app->getAction();
                $app->setBalise($action);
                $asset = $app->getAsset();
                $urlForDelete = $this->redirectToRoute('app_del',[
                    'position' => $number,
                ]);
                if ($appForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            if ($survey->getCas() === 'SDP_INC_3'){
                return $this->redirectToRoute('other_app');
            }else{
                return $this->redirectToRoute('rdv');
            }

        }

        if ($form->isSubmitted() && $form->isValid()){
            if ($survey->getCas() === 'SDP_INC_3'){
                return $this->redirectToRoute('other_app');
            }else{
                return $this->redirectToRoute('rdv');
            }
        }


        $cheminController->setChemins($request);
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
     * @Route("/LOGICIEL-2", name="other_app")
     */
    public function otherAppForm(Request $request, CheminController $cheminController): Response
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
                    $otherApp->setAsset('XX');
                }
                $survey->addOtherApp($otherApp);

                $action = $otherApp->getAction();
                $otherApp->setBalise($action);
                $asset = $otherApp->getAsset();
                $urlForDelete = $this->redirectToRoute('other_app_del',[
                    'position' => $number,
                ]);
                if ($otherAppForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            return $this->redirectToRoute('rdv');

        }

        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('rdv');
        }


        $cheminController->setChemins($request);
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
        $otherAppToDelete = $survey->getOtherApps()[$position];
        unset($survey->getOtherApps()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('OtherApp ' . $otherAppToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////









//////////////////////////////  PHONE FORM  //////////////////////////////
    /**
     * @Route("/TELEPHONIE", name="phone")
     */
    public function phoneForm(Request $request, CheminController $cheminController): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $phoneForm = $this->createForm(PhoneType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $phoneForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getPhones()); $i++ ){
            $number = $i;
        }

//
        if ($phoneForm->isSubmitted() && $number<=10){

            if ($phoneForm->get('action')->getData()){
                $phone = new Phone();
                $phone->setSurvey($survey);
                $phone->setPosition($number);
                $phone->setAsset($phoneForm->get('asset')->getData());
                $phone->setAction($phoneForm->get('action')->getData());
                $phone->setRsdp($phoneForm->get('rsdp')->getData());
                $phone->setTpx($phoneForm->get('tpx')->getData());
                if ($phone->getAsset()==null){
                    $phone->setAsset('XX');
                }
                $survey->addPhone($phone);

                $action = $phone->getAction();
                $phone->setBalise($action);
                $asset = $phone->getAsset();
                $urlForDelete = $this->redirectToRoute('phone_del',[
                    'position' => $number,
                ]);
                if ($phoneForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            return $this->redirectToRoute('rdv');

        }

        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('rdv');
        }


        $cheminController->setChemins($request);
        return $this->render('Survey/forms/phone_form.html.twig',[
            'form' => $form->createView(),
            'phone_form' => $phoneForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-phone={position}", name="phone_del")
     */
    public function delPhone($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $phoneToDelete = $survey->getPhones()[$position];
        unset($survey->getPhones()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('phone ' . $phoneToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////









//////////////////////////////  CMDB FORM  //////////////////////////////
    /**
     * @Route("/CMDB", name="cmdb")
     */
    public function cmdbForm(Request $request, CheminController $cheminController): Response
    {
        $form = $this->createForm(GlobalFormType::class);
        $cmdbForm = $this->createForm(CmdbType::class);
        $survey = $this->get('session')->get('survey');
        $form->handleRequest($request);
        $cmdbForm->handleRequest($request);
        for ($i=0; $i<=count($survey->getCmdbs()); $i++ ){
            $number = $i;
        }
//
        if ($cmdbForm->isSubmitted() && $number<=10){

            if ($cmdbForm->get('action')->getData()){
                $cmdb = new Cmdb();
                $cmdb->setSurvey($survey);
                $cmdb->setPosition($number);
                $cmdb->setAsset($cmdbForm->get('asset')->getData());
                $cmdb->setAction($cmdbForm->get('action')->getData());
                $cmdb->setNbAction($cmdbForm->get('nb_action')->getData());
                $cmdb->setRsdp($cmdbForm->get('rsdp')->getData());
                $cmdb->setTpx($cmdbForm->get('tpx')->getData());
                $action = $cmdb->getAction();
                $cmdb->setBalise($action);
                if ($cmdb->getAsset()==null){
                    $cmdb->setAsset('XX');
                }
                $survey->addCmdb($cmdb);

                $asset = $cmdb->getAsset();
                $urlForDelete = $this->redirectToRoute('cmdb_del',[
                    'position' => $number,
                ]);
                if ($cmdbForm->get('multiple')->getData() === true){
                    return $this->json(['action' => $action, 'asset' => $asset, 'position' => $number, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
                }
            }

            return $this->redirectToRoute('rdv');

        }

        if ($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('rdv');
        }


        $cheminController->setChemins($request);
        return $this->render('Survey/forms/cmdb_form.html.twig',[
            'form' => $form->createView(),
            'cmdb_form' => $cmdbForm->createView(),
            'survey' => $survey,
        ]);
    }

    /**
     * @Route("/del-cmdb={position}", name="cmdb_del")
     */
    public function delCmdb($position, Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $cmdbToDelete = $survey->getCmdbs()[$position];
        unset($survey->getCmdbs()[$position]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('cmdb ' . $cmdbToDelete . ' retiré !');

    }
////////////////////////////////////////////////////////////////////////////////////










    /**
     * @Route("/RDV", name="rdv")
     */
    public function rdv(Request $request, CheminController $cheminController): Response
    {
        $survey = $this->get('session')->get('survey');
        $rdvForm = $this->createForm(RdvType::class);
        $rdvForm->handleRequest($request);

        if ($rdvForm->isSubmitted() && $rdvForm->isValid()){
            $rdvTotal = $rdvForm->get('rdv_total')->getData();
            $rdvKoScc = $rdvForm->get('rdv_ko_scc')->getData();
            $rdvKoSafran = $rdvForm->get('rdv_ko_safran')->getData();
            $rdv = $survey->getRdvs();
            if ($rdvTotal != null || $rdvKoScc != null || $rdvKoSafran != null){
                if ( count($rdv) >= 1 ){
                    $survey->getRdvs()->clear();
                }
                $rdv = new Rdv();
                $rdv->setRdvTotal($rdvTotal);
                $rdv->setRdvKoScc($rdvKoScc);
                $rdv->setRdvKoSafran($rdvKoSafran);
                $rdv->setBalise('');
                $survey->addRdv($rdv);
            }

            return $this->redirectToRoute("commentaire");
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/forms/rdv_form.html.twig',[
            'rdv_form' => $rdvForm->createView(),
            'survey' => $survey,
        ]);
    }
    /**
     * @Route("/del-rdv", name="rdv_del")
     */
    public function delRdv(Request $request): Response
    {
        $survey = $this->get('session')->get('survey');
        $rdvToDelete = $survey->getRdvs()[0];
        unset($survey->getRdvs()[0]);
        $form = $this->createForm(GlobalFormType::class);
        $form->handleRequest($request);

        return $this->json('rdv ' . $rdvToDelete . ' retiré !');

    }










    /**
     * @Route("/COMMENTAIRE", name="commentaire")
     */
    public function description(Request $request, CheminController $cheminController): Response
    {
        $survey = $this->get('session')->get('survey');
        $commentaireForm = $this->createForm(DescriptionFormType::class);
        $commentaireForm->handleRequest($request);

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()){
            $commentaire = $commentaireForm->get('commentaire')->getData();
            $survey->setCommentaire($commentaire);
            return $this->redirectToRoute("final_string");
        }

        $cheminController->setChemins($request);
        return $this->render('Survey/forms/commentaire_form.html.twig',[
            'commentaire_form' => $commentaireForm->createView(),
            'survey' => $survey,
        ]);
    }



}
