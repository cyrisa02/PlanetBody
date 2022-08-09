<?php

namespace App\Form;

use App\Entity\Sporthall;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SporthallType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('contact')
            ->add('isEnable', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label' => 'Actif     ?    .',
                'label_attr' => [
                    'class' => 'form-check-label'
                ]
                
            ])
            //->add('permissions')
            //->add('mailings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sporthall::class,
        ]);
    }
}