<?php

namespace App\Form;

use App\Controller\SurveySessionController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeInterTasktForm extends AbstractType
{
    private $survey;

    public function __construct(SurveySessionController $surveySessionController)
    {
        $this->survey =  $surveySessionController->checkSurveySession();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $survey = $this->survey;
        $service = $survey->getService();
        $methode = $survey->getResolveMethod();

        if ($service == 'HD' || $methode == 'PMAD'){
            $builder
                ->add('type', ChoiceType::class,
                    array('label' => false,
                        'required' => true,
                        'choices' => [
                            'Installation d’applications sans fourniture de matériel' => '3',
                            'Autres actions logiciel et accès' => '5',
                            'Support téléphonie' => '6',
                            'Actions CMDB' => '7',
                        ]
                    )
                )
            ;
        }else{
            $builder
                ->add('type', ChoiceType::class,
                    array('label' => false,
                        'required' => true,
                        'choices' => [
                            'Fourniture, reprise et déménagement de postes de travail' => '1',
                            'Fourniture, reprise et déménagement de matériels hors postes de travail' => '2',
                            'Installation d’applications sans fourniture de matériel' => '3',
                            'Autres actions matériel' => '4',
                            'Autres actions logiciel et accès' => '5',
                            'Support téléphonie' => '6',
                            'Actions CMDB' => '7',
                        ]
                    )
                )
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
