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
                    'multiple' => false,
                    'expanded' => true,
//                'choice_label' => false,
                    'choices' => [
                        'Changement de PC' => 'inct_1',
                        'Autre intervention matérielle' => 'inct_2',
                        'Intervention software' => 'inct_3',
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
