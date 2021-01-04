<?php

namespace App\Controller;



use App\Entity\Survey;
use App\Entity\User;
use App\Form\AssetTypeFormType;
use App\Form\DescriptionFormType;
use App\Form\FinalStringFormType;
use App\Form\HostnameFormType;
use App\Form\NewUserType;
use App\Form\TypeFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $superAdmin = $userRepository->findOneBy(['email' => 'cboungou@fr.scc.com']);
        if (!$superAdmin){
            $superAdmin = New User();
            $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
            $password = '121090cb.K4gur0';
            $superAdmin->setEmail('cboungou@fr.scc.com');
            $superAdmin->setPassword(
                $passwordEncoder->encodePassword(
                    $superAdmin,
                    $password
                )
            );
            $em->persist($superAdmin);
            $em->flush();
        }


        $form = $this->createForm(TypeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $type = $form->get("type")->getData();

            $this->addFlash('info', $type . ' selectionné !');

            if ($type == "demande"){
                return $this->redirectToRoute("taskt_from_inct",  [
//                    'type' => $type,
                ]);
            }else{
                return $this->redirectToRoute("home", [
//                    'type' => $type,
                ]);
            }

        }
        return $this->render('Survey/home.html.twig');
    }



    /**
     * @Route("from-inct={from_inct}/type-asset={asset_type}/intervention={intervention}/new-user={new_user}/hostname={hostname}/description", name="description")
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
