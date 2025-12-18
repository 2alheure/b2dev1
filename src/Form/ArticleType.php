<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArticleType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('titre', TextType::class)
            ->add('date', DateType::class, [
                'constraints' => [
                    new NotBlank,
                    new GreaterThanOrEqual('today')
                ]
            ])
            ->add('img', FileType::class, [
                'label' => 'Image (URL)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Laisser vide si pas d\'image'
                ],
                'constraints' => [
                    new NotBlank(),
                    new File(
                        maxSize: '5M',
                        extensions: ['jpeg', 'jpg', 'png', 'webp', 'gif']
                    )
                ]
            ])
            ->add('contenu', TextareaType::class)
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
