<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\HomeType;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER")
     */
    public function home(Request $request, EntityManagerInterface $em, SurveyRepository $surveyRepository): Response
    {
        $form = $this->createForm(HomeType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($user->getSurvey()){
            $surveyId = $user->getSurvey()->getId();
            $actualSurvey = $surveyRepository->find($surveyId);
            $em->remove($actualSurvey);
            $em->flush();
        }
        if ($form->isSubmitted() && $form->isValid()){
            $survey = New Survey();
            $survey->setUser($user);
            $survey->setType('Demande');
            $em->persist($survey);
            $em->flush();

            return $this->redirectToRoute('taskt_from_inct',[
                'survey' => $survey,
            ]);
        }
        return $this->render('Survey/home.html.twig',[
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user={new_user}/hostname={hostname}/description", name="description")
     * @IsGranted("ROLE_USER")
     */
    public function description(Request $request, $from_inct, $asset_type, $intervention, $new_user, $hostname): Response
    {
        $form = $this->createForm(DescriptionFormType::class);
        $form->handleRequest($request);
//        $previousUrl = $request->headers->get('referer');

        if ($form->isSubmitted() && $form->isValid()){
            $infos = $form->get('infos')->getData();

                return $this->redirectToRoute("final_string",  [
                    'infos' => $infos,
                    'from_inct' => $from_inct,
                    'asset_type' => $asset_type,
                    'hostname' => $hostname,
                    'intervention' => $intervention,
                    'new_user' => $new_user,
                ]);

        }
        return $this->render('Survey/description_form.html.twig',[
            'description_form' => $form->createView(),
            'from_inct' => $from_inct,
            'asset_type' => $asset_type,
            'hostname' => $hostname,
            'intervention' => $intervention,
            'new_user' => $new_user,
//            'previous_url' => $previousUrl,
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
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user={new_user}/hostname={hostname}/validation", name="final_string", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function stringGen(Request $request, $from_inct ,$asset_type, $new_user, $hostname, $intervention): Response
    {
        $textDescription = $_POST['description_text'];
        $text = preg_replace('/\s\s+/', ' ', $textDescription);

        $from_inct = $this->miseEnForm($from_inct, 'Suite à incident : ');
        $asset_type = $this->miseEnForm($asset_type, 'Type de matériel : ');
        $new_user = $this->miseEnForm($new_user,'Nouvel arrivant : ');
        $hostname = $this->miseEnForm($hostname,'Hostname : ');
        $intervention = $this->miseEnForm($intervention,'Type d\'intervention : ');
        $description = $this->miseEnForm($text, 'Déscription : ');

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
