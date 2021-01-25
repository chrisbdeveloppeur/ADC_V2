<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeInterInctForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('choices', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Fourniture, reprise et déménagement de postes de travail' => '1',
                        'Fourniture, reprise et déménagement de matériels hors postes de travail' => '2',
                        'Installation d’applications sans fourniture de matériel.' => '3',
                        'Autres actions matériel' => '4',
                        'Autres actions logiciel et accès' => '5',
                        'Support téléphonie' => '6',
                        'Actions CMDB' => '7',
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
