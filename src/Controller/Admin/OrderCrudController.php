<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index','detail');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('createdAt','Passée le'),
            TextField::new('user.fullname','Utilisateur'),
            EmailField::new('user.email','Contact'),
            TextEditorField::new('delivery','Adresse de livraison'),
            MoneyField::new('total')->setCurrency('EUR'),
            ChoiceField::new('state','Etat de la commande')->setChoices([
                'Non Payé'=>0,
                'Payé'=>1,
                'Préparation en cours'=>2,
                'Livraison en cours'=>3,
                'Livré'=>4,

            ])
        ];
    }
    
}
