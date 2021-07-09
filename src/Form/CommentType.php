<?php

namespace App\Form;


use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author'  , TextType::class ,[
                'label' => 'votre nom',
                'attr' => [
                'class' => 'form-control'
                ]])
            ->add('email' , EmailType::class ,[
                'label' => 'votre email',
                'attr' => [
                'class' => 'form-control'
                ]])
            ->add('content'  , TextareaType::class,[
                'label' => 'commentaire',
                'attr' => [
                'class' => 'form-control'
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
