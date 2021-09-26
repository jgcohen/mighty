<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('new_password', RepeatedType::class,[
            'type' => PasswordType::class,
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
            'label' =>"Mettre à jour mon mot de passe",
            'attr'=>[
                'class'=>'btn btn-gold btn-block'
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
