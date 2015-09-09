<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Biblioteca\TegBundle\Form\documentoType;
use Biblioteca\UserBundle\Form\Type\RegistrationType;
class tegType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('escuela', 'choice',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Seleccionar escuela',
                    'choices'  => array(
                        'Computacion' => 'Computación',
                        'Quimica' => 'Química',
                        'Matematica' => 'Matemática',
                        'Biologia' => 'Biología',
                        'Fisica' => 'Física'),
                    'required' => true,
                )
            )
            ->add('cota', 'integer', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control',
                                    'min' => '1',
                                    'max' => '99'),
                )

            )
            ->add('publicacion', 'birthday',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(1998, date('Y')),
                    'months' => range(1, date('m')),
                    'days' => range(1, date('d')),
                    'empty_value' => 
                        array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'),
//                    'attr'      => array('class' => 'form-control'),
                )
            )
            ->add('titulo', 'text', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control'),
                )
            )
            ->add('palabrasClave', 'collection',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    // cada elemento en el arreglo debe ser un campo "email"
                    //'type'   => 'email',
                    // estas opciones se pasan a cada tipo "email"
                    'allow_add' => true,
                    'allow_delete' => true,
                    
                    'prototype' => true,
                    //'prototype_name' => 'tag__name__',
                    'options'  => array(
                        'required'  => true,
                        'attr'      => array('class' => 'form-control')
                        ),
                )
            )
            ->add('resumen', 'textarea',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control',
                                     'row' => '3')
                )
            )
            //->add('capitulo', new documentoType(), array('label' => 'Capítulo (PDF file)'))
        ;
        $builder
            ->add('autores', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),
                // cada elemento en el arreglo debe ser un campo "email"
                //'type'   => 'text',
                'allow_add' => true,
                'prototype' => true,
         
                'options'  => array(
                    'required'  => false,
                    'attr'      => array('class' => 'form-control')
                    ),
                )
            )
        ;
        //$builder->add('capitulos');
/*        $builder->add('capitulos', 'collection', array(
            'type' => new documentoType(),
            'empty_data'  => null
            )
        );
*/
        $builder
            ->add('capitulos', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),
                // cada elemento en el arreglo debe ser un campo "email"
                'type' => new documentoType(),
                'allow_add' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => false,
                    'attr'      => array('class' => '')
                    ),
                )
            )
        ;/*
        $builder
            ->add('capitulos', 'entity', array(
                'class' => 'BibliotecaTegBundle:documento',
                'choice_label' => 'id',
                )
            )
        ;*/
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Biblioteca\TegBundle\Entity\teg'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'biblioteca_tegbundle_teg';
    }
}
