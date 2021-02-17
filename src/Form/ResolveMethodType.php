<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolveMethodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('method', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'multiple' => false,
                    'expanded' => true,
//                'choice_label' => false,
                    'choices' => [
                        'Guichet' => 'GUICHET',
                        'PMAD' => 'PMAD',
                        'Plateau' => 'PLATEAU',
                        'Autre' => 'AUTRE',
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
