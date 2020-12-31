<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostnameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('customHostname', TextType::class,[
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => 'input is-info',
                        'placeholder' => 'Exemple : SDS-1A2B'
                    ]
                ]
            )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
//            'data_class' => Survey::class,
        ]);
    }
}
