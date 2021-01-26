<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeInterTasktForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('choices', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Fourniture, reprise et déménagement de postes de travail' => 'taskt_1',
                        'Fourniture, reprise et déménagement de matériels hors postes de travail' => 'taskt_2',
                        'Installation d’applications sans fourniture de matériel.' => 'taskt_3',
                        'Autres actions matériel' => 'taskt_4',
                        'Autres actions logiciel et accès' => 'taskt_5',
                        'Support téléphonie' => 'taskt_6',
                        'Actions CMDB' => 'taskt_7',
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
