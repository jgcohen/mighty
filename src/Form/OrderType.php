<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        $builder
            ->add('addresses',EntityType::class,[
                'label'=>false,
                'required'=>true,
                'class'=>Address::class,
                'choices'=>$user->getAddresses(),
                'multiple'=>false,
                'expanded'=>true
            ])

            // ->add('carrieres',EntityType::class,[
            //     'label_html'=> true,
            //     'label'=>'Choisissez votre transporteur <br> (si votre commande comprend un mug, merci de choisir Colissimo)',
            //     'required'=>true,
            //     'class'=>Carrier::class,
            //     'multiple'=>false,
            //     'expanded'=>true
            // ])

            ->add('submit', SubmitType::class,[
                'label'=>'Valider ma commande',
                'attr'=>[
                    'class'=>'btn btn-gold btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user'=>array()
        ]);
    }
}
