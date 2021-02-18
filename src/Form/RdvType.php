<?php

namespace App\Form;

use App\Controller\SurveySessionController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RdvType extends AbstractType
{

    private $survey;

    public function __construct(SurveySessionController $surveySessionController)
    {
        $this->survey =  $surveySessionController->checkSurveySession();

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $survey = $this->survey;
        if ( $survey->getResolveMethod() == 'PMAD' || $survey->getService() == 'HD' ){
            $builder
                ->add('rdv', ChoiceType::class,
                    array(
                        'label' => false,
                        'required' => false,
                        'multiple' => false,
                        'expanded' => true,
                        'placeholder' => false,
                        'choices' => [
                            'Non' => 'non',
                            'Oui' => 'oui',
                        ],
                        'data' => 'non',
                    )
                )
                ->add('balise', ChoiceType::class,
                    array('label' => false,
                        'required' => false,
                        'placeholder' => false,
                        'choices' => [
                            'Le RDV a été respecté, ou bien n\'a pas eu lieu pour une raison non imputable à SCC (panne réseau…)' => 'RDV RESPECTE OUI',
                            'L\'utilisateur n\'était pas présent au RDV (sans avoir prévenu)' => 'RDV RESPECTE NON',
                            'Le Rendez-vous a été annulé par l\'utilisateur' => 'RDV ANNULE USER',
                            'SCC n\'était pas présent au RDV (sans avoir prévenu)' => 'RDV NON RESPECTE SCC',
                            'Le Rendez-vous a été annulé par SCC' => 'RDV ANNULE SDP',
                        ],
                    )
                )

                ->add('rsdp', ChoiceType::class,[
//                'label' => false,
                        'required' => false,
                        'placeholder' => false,
                        'expanded' => true,
                        'choices' => [
                            'Fait à distance' => 'XX',
                        ],
                        'data' => 'XX',
                    ]
                );

        }else{
            $builder
                ->add('rdv', ChoiceType::class,
                    array(
                        'label' => false,
                        'required' => false,
                        'multiple' => false,
                        'expanded' => true,
                        'placeholder' => false,
                        'choices' => [
                            'Non' => 'non',
                            'Oui' => 'oui',
                        ],
                        'data' => 'non',
                    )
                )
                ->add('balise', ChoiceType::class,
                    array('label' => false,
                        'required' => false,
                        'placeholder' => false,
                        'choices' => [
                            'Le RDV a été respecté, ou bien n\'a pas eu lieu pour une raison non imputable à SCC (panne réseau…)' => 'RDV RESPECTE OUI',
                            'L\'utilisateur n\'était pas présent au RDV (sans avoir prévenu)' => 'RDV RESPECTE NON',
                            'Le Rendez-vous a été annulé par l\'utilisateur' => 'RDV ANNULE USER',
                            'SCC n\'était pas présent au RDV (sans avoir prévenu)' => 'RDV NON RESPECTE SCC',
                            'Le Rendez-vous a été annulé par SCC' => 'RDV ANNULE SDP',
                        ],
                    )
                )

                ->add('rsdp', ChoiceType::class,[
//                'label' => false,
                        'required' => false,
                        'placeholder' => false,
                        'expanded' => true,
                        'choices' => [
                            'Non' => 'NON',
                            'Oui' => 'OUI',
                        ],
                        'data' => 'NON',
                    ]
                );
        }


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
