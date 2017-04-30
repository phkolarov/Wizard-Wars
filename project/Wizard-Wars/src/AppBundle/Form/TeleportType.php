<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 29.4.2017 г.
 * Time: 22:18
 */

namespace AppBundle\Form;


use AppBundle\Form\types\Teleport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeleportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('positionX', IntegerType::class,['attr'=>['class'=>'form-control', 'placeholder'=> 'Recommend position between 0 - 9000']])
            ->add('positionY', IntegerType::class,['attr'=>['class'=>'form-control','placeholder'=> 'Recommend position between 0 - 8000']])
            ->add('manaCost',IntegerType::class,['attr'=>['class'=>'form-control','value' => '400','disabled'=>'disabled']]);
    }



    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class'=> Teleport::class
        ]);

    }


    public function getName()
    {
        return "teleport_type";
    }


}