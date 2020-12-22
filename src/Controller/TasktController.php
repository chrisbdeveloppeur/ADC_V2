<?php

namespace App\Controller;

use App\Form\AssetTypeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("{type}/", name="taskt_")
 */
class TasktController extends AbstractController
{
//    /**
//     * @Route("type-asset", name="asset_type")
//     */
//    public function setAssetType(Request $request, $type): Response
//    {
//        $form = $this->createForm(AssetTypeFormType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()){
////            $user = $form->getData();
////            $entityManager->persist($user);
//            $assetType = $form->get("assetType")->getData();
//
//            if ( ($assetType == "other") ){
//                $this->addFlash('success', 'Le type' . $assetType . ' à été selectionné !');
////                dd($type, $assetType);
//                return $this->redirectToRoute("taskt_asset_type");
//            }else{
//                $this->addFlash('success', $assetType . ' selectionné !');
////                dd($type, $assetType);
//                return $this->redirectToRoute("taskt_asset_type");
//            }
//
//        }
//        return $this->render('Survey/Taskt/asset_type_field.html.twig', [
//            'asset_type_field_form' => $form->createView(),
//        ]);
//    }
}
