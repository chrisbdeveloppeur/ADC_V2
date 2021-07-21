<?php

namespace App\Form;

use App\Controller\SurveySessionController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppType extends AbstractType
{
    private $survey;

    public function __construct(SurveySessionController $surveySessionController)
    {
        $this->survey =  $surveySessionController->checkSurveySession();

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $survey = $this->survey;

            $builder
                ->add('action', ChoiceType::class, [
                        'required' => false,
                        'placeholder' => 'Selectionner...',
                        'choices' => [
                            'Applications télédistribuées' => 'SFW_TLD',
                            'Applications installées localement ou en PMAD, sans tentative préalable de télédistribution' => 'SFW_LOC',
                            'Applications installées localement ou en PMAD, après un échec de télédistribution' => 'SFW_TLK',
                        ]
                    ]

                )
                ->add('asset', TextType::class,[
                        'required' => false,
                    ]
                )
                ->add('rsdp', ChoiceType::class,[
                        'required' => false,
                        'placeholder' => false,
                        'expanded' => true,
                        'choices' => [
                            'Oui' => 'oui',
                            'Non' => 'non',
                            'Fait à distance' => 'N/A',
                        ],
                        'data' => 'N/A',
                    ]
                )
                ->add('tpx', IntegerType::class,[
                        'required' => false,
                    ]
                )
                ->add('multiple', CheckboxType::class,[
                        'required' => false,
                    ]
                )
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
