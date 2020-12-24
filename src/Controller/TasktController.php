<?php

namespace App\Controller;

use App\Form\AssetTypeFormType;
use App\Form\FromInctFormType;
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
    /**
     * @Route("from-inct", name="from_inct")
     */
    public function fromInct(Request $request, $type): Response
    {
        $form = $this->createForm(FromInctFormType::class);
        $form->handleRequest($request);
        $from_inct = $form->get('from_inct')->getData();

        if ($form->isSubmitted() && $form->isValid()){
            if ($from_inct == 'non'){
                return $this->redirectToRoute("asset_type",  [
                    'type' => $type,
                    'from_inct' => $from_inct,
                ]);
            }else{
                return $this->redirectToRoute("asset_type",  [
                    'type' => $type,
                    'from_inct' => $from_inct,
                ]);
            }

        }
        return $this->render('Survey/Taskt/from_inct_field.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }
}
