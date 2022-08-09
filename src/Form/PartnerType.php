<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('contact')
            //->add('contract')
            ->add('is_enable', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
                'label' => 'Actif     ?    .',
                'label_attr' => [
                    'class' => 'form-check-label'
                ]
                
            ])

            //->add('sporthalls')
            //->add('permissions')
            //->add('mailings')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}