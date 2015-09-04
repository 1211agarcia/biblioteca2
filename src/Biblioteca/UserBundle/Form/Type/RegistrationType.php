<?php

namespace Biblioteca\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('roles', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),
                // cada elemento en el arreglo debe ser un campo "email"
                'type'   => 'choice',
                'allow_add' => true,
                'prototype' => true,
                // estas opciones se pasan a cada tipo "email"
                'options'  => array(
                    'required'  => true,
                    'attr'      => array('class' => 'form-control'),
                    'choices'  => array(
                        'ROLE_USER' => 'Normal',
                        'ROLE_ADMIN' => 'Administrador'),
                    ),
                )
            )
        ;
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