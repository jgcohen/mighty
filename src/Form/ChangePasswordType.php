<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'disabled'=> true,
                'label'=>'Mon adresse E-Mail'
            ])
            ->add('firstname', TextType::class,[
                'disabled'=> true,
                'label'=>'Mon prénom'
            ])
            ->add('lastname',TextType::class,[
                'disabled'=> true,
                'label'=>'Mon nom'
            ])
            ->add('old_password', PasswordType::class,[ 
            'mapped'=>false,
            'label'=>'Mon mot de passe actuel',
            'attr' =>[
                'placeholder'=>'Veuillez saisir votre mot de passe actuel'
            ]
            ])

            ->add('new_password', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped'=>false,
                'constraints'=> new Length([
                'min' => 8,
                'max' => 17]),
                'invalid_message'=> 'Le message et la confirmation doivent etre identiques',
                'label' =>'Mon nouveau mot de passe',
                'required'=> true,
                'first_options'=>['label'=>'Mon nouveau mot de passe(minimum 8 caracteres)',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]],
                'second_options'=>['label'=>'Confirmez votre nouveau mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmation'
                ]],
                
            ])
            ->add('submit', SubmitType::class,[
                'label' =>"Modifier"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
