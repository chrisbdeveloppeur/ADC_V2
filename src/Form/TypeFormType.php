<?php

namespace App\Form;

use App\Controller\SurveySessionController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeFormType extends AbstractType
{
//    private $survey;
//
//    public function __construct(SurveySessionController $surveySessionController)
//    {
//        $this->survey =  $surveySessionController->checkSurveySession();
//    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('type', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
//                'choice_label' => false,
                    'choices' => [
                        'Demande' => 'DEM',
                        'incident' => 'INC',
                    ]
                )
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
