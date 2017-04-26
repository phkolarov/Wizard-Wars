<?php
/**
 * Created by PhpStorm.
 * User: mst
 * Date: 25.4.2017 г.
 * Time: 23:30
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LycanType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countOfLycans', NumberType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

}