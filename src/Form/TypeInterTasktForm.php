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
            ->add('typeInter', ChoiceType::class,
                array('label' => false,
                    'required' => true,
                    'choices' => [
                        'Changement de PC' => 'changement de PC',
                        'Autre intervention matérielle' => 'autre intevention materielle',
                        'Intervention software' => 'intervention software',
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
