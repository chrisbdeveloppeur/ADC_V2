<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Entity\OtherAsset;
use App\Form\AssetType;
use App\Form\GlobalFormType;
use App\Form\OtherAssetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/form", name="form_")
 */

class FormsController extends AbstractController
{

    /**
     * @Route("/asset", name="asset")
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
            $newAsset->setRspd($assetForm->get('rspd')->getData());
            $newAsset->setDuree($assetForm->get('tpx')->getData());
            if ($newAsset->getNewHostname()==null){
                $newAsset->setNewHostname('N/A');
            }
            if ($newAsset->getCurrentHostname()==null){
                $newAsset->setCurrentHostname('N/A');
            }
            $survey->addAsset($newAsset);

//            dd($newAsset->getType());

            $action = $newAsset->getAction();
            $type = $newAsset->getType();
            $ae = $newAsset->getNewHostname();
            $as = $newAsset->getCurrentHostname();
            $urlForDelete = $this->redirectToRoute('form_asset_del',[
                  'position' => $number,
                ]);

//            dd($urlForDelete);

//            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
//            return $this->redirect($referer);
            return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as, 'url_for_delete' => $urlForDelete->getTargetUrl()]);
        }

        if ($form->isSubmitted()){
            return $this->redirectToRoute('form_other_asset');
        }

        return $this->render('Survey/assets_form.html.twig',[
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









    /**
     * @Route("/other-asset", name="other_asset")
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
            $newAsset->setRspd($otherAssetForm->get('rspd')->getData());
            $newAsset->setDuree($otherAssetForm->get('tpx')->getData());
            if ($newAsset->getNewHostname()==null){
                $newAsset->setNewHostname('N/A');
            }
            if ($newAsset->getCurrentHostname()==null){
                $newAsset->setCurrentHostname('N/A');
            }
            $survey->addOtherAsset($newAsset);

            $action = $otherAssetForm->get('action')->getData();
            $type = $otherAssetForm->get('type')->getData();
            $ae = $otherAssetForm->get('ae')->getData();
            $as = $otherAssetForm->get('ae')->getData();

            $referer = $request->headers->get('referer'); ////// PREVIOUS URL ////////
            return $this->redirect($referer);
//            return $this->json(['action' => $action,'type' => $type,'ae' => $ae,'as' => $as]);
        }

        if ($form->isSubmitted()){
//            return $this->redirectToRoute();
        }

        return $this->render('Survey/other_assets_form.html.twig',[
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




}
