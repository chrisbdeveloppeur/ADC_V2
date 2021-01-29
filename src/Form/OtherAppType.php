<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OtherAppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', ChoiceType::class, [
//                'label' => false,
                    'required' => false,
                    'placeholder' => false,
                    'choices' => [
                        'Queue d\'impression' => 'SFW_QUE',
                        'Configuration d\'une imprimante' => 'SFW_CFP',
                        'Demande de sauvegarde' => 'SFW_SAV',
                        'Habilitation utilisateur en local' => 'SFW_HLO',
                        'Réactivation de compte / modification des ACL traitées à distance' => 'SFW_ACL',
                        'Création modification de 1 à 10 utilisateurs par programme, à distance' => 'SFW_TEN',
                        'Accompagnement sur MyVisio (nombre de tranches de 20 minutes)' => 'MEP_MYV',
                        'Accompagnement sur MyMobility (nombre de tranches de 20 minutes)' => 'MEP_SNW',
                        'Habilitation AD traitée à distance' => 'HAB_CAD',
                        'Compte Mymobility /  VPN' => 'SFW_MYM',
                        'Compte Airwatch' => 'SFW_AIR',
                        'Création de compte MFT' => 'SFW_MFT',
                        'Compte Unix' => 'SFW_UNX',
                        'Compte SAP' => 'SFW_SAP',
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
                    ],
                    'data' => 'N/A',
                ]
            )
            ->add('tpx', IntegerType::class,[
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
