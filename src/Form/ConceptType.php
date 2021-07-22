<?php

namespace App\Form;

use App\Entity\Concept;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ConceptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        ->add('imageFile', VichImageType::class,[
             
            'required' => false,
            'allow_delete' => false,
            'delete_label' => '',
            'download_label' => '',
            'download_uri' => true,
            'image_uri' => true,     
            
        ])
            ->add('title')
            ->add('description')
        ;
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concept::class,
        ]);
    }
}
