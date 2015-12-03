<?php

namespace Biblioteca\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('roles', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),
                'type'   => 'choice',
                'allow_add' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => true,
                    'attr'      => array('class' => 'form-control'),
                    'choices'  => array(
                        '1' => 'Estudiante',
                        '2' => 'Administrador'),
                    ),
                )
            )
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Biblioteca\UserBundle\Entity\usuario'
        ));
    }
    
    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'biblioteca_user_registration';
    }
}