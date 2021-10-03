<?php

namespace App\Controller\Admin;

use App\Entity\Events;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Events::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('name'),
            TextareaField::new('description'),
            TextField::new('address'),
            ImageField::new('illustration')->setBasePath('uploads/')->setUploadDir('public/uploads/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            ImageField::new('secondIllustration')->setBasePath('uploads/')->setUploadDir('public/uploads/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            ImageField::new('thirdIllustration')->setBasePath('uploads/')->setUploadDir('public/uploads/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
  
        ];
    }
    
}
