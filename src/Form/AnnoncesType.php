<?php

namespace App\Form;

use App\Entity\Annonces;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => "titre de l'article" , 'class' => "form-control"
                    ] 
            ])
            ->add('introduction', TextareaType::class,[
                'attr' => [
                    'placeholder' => "l'introduction", 'class' => "form-control"
                ]
            ]) 
            ->add('adresse', TextType::class,[
                'attr' => [
                    'placeholder' => "Commentaire de l'article",  'class' => "form-control"
                ]
            ])
            ->add('description', TextareaType::class,[
                'attr' => [
                    'placeholder' => "description de l'article", 'class' => "form-control"
                ]
            ])
            ->add('price', IntegerType ::class,[
                'attr' => [
                    'placeholder' => "le prix de l'article", 'class' => "form-control"
                ]
            ])
            ->add('coverImage', FileType::class, [
                'required' => false,
                'data_class' => null,
            ])
            ->add('room', TextType ::class,[
                'attr' => [
                   'class' => "form-control"
                ]
            ])
            ->add('isAvailable');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
