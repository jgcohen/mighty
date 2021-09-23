<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('firstname', TextType::class,[
            'label'=>'Votre prénom',
            'attr'=>[
                'placeholder'=>'Merci de saisir votre prénom'
            ]
        ])
        ->add('lastname', TextType::class,[
            'label'=>'Votre nom',
            'attr'=>[
                'placeholder'=>'Merci de saisir votre nom'
            ]
        ])
            ->add('email', EmailType::class, [
                'label' => 'Votre E-Mail',
                'attr' => [
                    'placeholder' =>"E-Mail"
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'constraints'=> new Length([
                'min' => 8,
                'max' => 17]),
                'invalid_message'=> 'Le message et la confirmation doivent etre identiques',
                'required'=> true,
                'first_options'=>['label'=>'Mot de passe(minimum 8 caracteres)',
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]],
                'second_options'=>['label'=>'Confirmez le mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmation'
                ]],
                
            ])
          
            ->add('submit', SubmitType::class,[
                'label' =>"S'inscrire",
                'attr' =>[
                    'class' => 'btn-block btn-gold mb-5'
                ]
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
