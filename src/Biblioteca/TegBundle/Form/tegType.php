<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Biblioteca\TegBundle\Form\documentoType;
use Biblioteca\TegBundle\Entity\teg;
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
            ->add('published', 'checkbox',
                array(
                    'label'    => '¿Mostrar públicamente?',
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'checkbox-inline','data-on-text'=> 'Sí','data-off-text'=> 'No'),
                    'required' => false,
                )
            )
            ->add('escuela', 'choice',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control form-compacto'),
                    'empty_value' => 'Seleccionar',
                    'choices'  => teg::getSchools(),
                    'required' => true,
                )
            )
            ->add('cota', 'text', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control',
                                    'readonly' => 'true',
                                    'placeholder' => 'D[Escuela]-[indice]-[Año de Publicación]'),
                )

            )
            ->add('publicacion', 'birthday',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr' => array('class' => 'col-xs-9'),
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(1998, date('Y')),
                    'months' => range(1, date('m')),
                    'days' => range(1, date('d')),
                    'empty_value' => 
                        array('day' => 'Dia', 'month' => 'Mes', 'year' => 'Año'),
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
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
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
                'options'  => array(
                    'required'  => true,
                    'attr'      => array('class' => 'form-control')
                    ),
                )
            )
        ;
        $builder
            ->add('tutores', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),        
                'options'  => array(
                    'required'  => true,
                    'attr'      => array('class' => 'form-control')
                    ),
                )
            )
        ;

        $builder
            ->add('capitulos', 'collection', array(
                'label_attr' => array('class' => 'control-label col-xs-3'),
                'type' => new documentoType(),
                'allow_add' => true,
                'prototype' => true,
                'options'  => array(
                    'required'  => false,
                    'attr'      => array('class' => '')
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
