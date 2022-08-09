<?php

namespace App\Form;

use App\Entity\Partner;
use App\Entity\Permission;
use App\Repository\PermissionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerPermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('contact')
            //->add('contract')
            //->add('is_enable')
            //->add('sporthalls')
            ->add('permissions', EntityType::class, [
                'class' => Permission::class,
                // 'query_builder' => function (PermissionRepository $r) {
                //     return $r->createQueryBuilder('i')
                //         ->where('i.user = :user')
                //         ->orderBy('i.name', 'ASC')
                //         ->setParameter('user', $this->token->getToken()->getUser());
                // },
                'label' => 'Les Permissions du franchisé',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}