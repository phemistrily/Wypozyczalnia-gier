<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SoldGames;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('price', MoneyType::class, ['label'=> 'Cena ', 'currency' => 'PLN'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        $resolver->setDefaults([
//            'data_class' => SoldGames::class,
//        ]);
    }
}
