<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OtherActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', ChoiceType::class, [
//                'label' => false,
                    'required' => false,
                    'placeholder' => 'Selectionner...',
                    'choices' => [
                        'Brassage physique utilisateur' => 'NWK_BRS',
                        'Visite préventive d\'une salle de réunion' => 'VER_SAL',
                        'Masterisation d\'un poste  + ajout CMDB' => 'MAS_CMD',
                        'Masterisation d\'un poste SANS ajout CMDB' => 'SPP_MAS_NOC',
                        'Petit matériel : cartouches imprimantes, piles de périphériques sans fil, souris / claviers / station d\'accueil' => 'INS_PRT',
                        'Imprimantes individuelles' => 'INS_PMA',
                        'Blanchiment de matériel' => 'STK_TRF',
                        'Intervention sur matériel autonome' => 'MAT_AUT',
                    ]
                ]

            )
            ->add('asset', TextType::class,[
//                    'label' => false,
                    'required' => false,
                ]
            )
            ->add('rsdp', ChoiceType::class,[
//                'label' => false,
                    'required' => false,
                    'placeholder' => false,
                    'expanded' => true,
                    'choices' => [
                        'Oui' => 'oui',
                        'Non' => 'non',
//                        'Sans RDV' => 'N/A',
                    ],
                    'data' => 'oui',
                ]
            )
            ->add('tpx', IntegerType::class,[
//                'label' => false,
                    'required' => false,
                ]
            )
            ->add('multiple', CheckboxType::class,[
//                'label' => false,
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
