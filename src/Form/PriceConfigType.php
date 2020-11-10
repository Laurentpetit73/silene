<?php

namespace App\Form;

use App\Entity\PriceConfig;
use App\Form\DefaultDayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PriceConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('defaultDays',CollectionType::class,[
                'entry_type'   => DefaultDayType::class,
            ])
            ->add('specialWeeks',CollectionType::class,[
                'entry_type'   => SpecialWeekType::class,
                'allow_add' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PriceConfig::class,
        ]);
    }
}
