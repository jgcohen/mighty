<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('prenom',TextType::class,[
                'label' =>"Prénom"
            ])
             ->add('nom',TextType::class,[
                'label' =>"Nom"
            ])
            ->add('email', EmailType::class,[
                'label' =>"E-Mail"
            ])
            ->add('content', TextareaType::class,[
                'label' =>"Votre Message"
            ])

            ->add('submit', SubmitType::class,[
                'label' =>"Envoyer",'attr' =>[
                    'class' => 'btn-block btn-gold mb-5'
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
