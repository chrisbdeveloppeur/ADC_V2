<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCmdbDifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_cmdb_dif', ChoiceType::class,[
                'label' => false,
                'mapped' => false,
                'multiple' => false,
                'expanded' => true,
//                'choice_label' => false,
                'choices' => [
                    'Oui' => 'OUI',
                    'Non' => 'NON',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
