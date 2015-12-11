<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Biblioteca\TegBundle\Entity\teg;

class searchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->setMethod('GET')
            ->add('q', 'text', 
                array(
                    'attr'=> array('maxlength' => '200',
                                    'required' => false,
                                   'placeholder' => 'Palabra o frase...',
                                   'ng-model'=>'q',
                                   'xng-required'=>'isInvalid()'),
                )
            )
            ->add('submit', 'submit', 
                array('label'=> 'Buscar',
                    'attr'=> array('value'=> 'Buscar','ng-disabled'=> 'isInvalid()', 'ng-click' => 'load($event)', 'ng-model' => 'loading', 'Xdisabler'=>'Cargando'))
            )
            ->add('desde', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                    'label_attr' => array('class' => 'form-control-static'),
                    'attr'=> array('ng-model'=>'desde'),
                )
            )
            ->add('hasta', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                    'label_attr' => array('class' => 'form-control-static'),
                    'attr'=> array('ng-model'=>'hasta'),
                )
            )
            ->add('escuela', 'choice',
                array(
                    'empty_value' => 'Cualquier escuela',
                    'choices'  => teg::getSchools(),
                    'required' => false,
                    'label' => false,
                    'attr'=> array('ng-model'=>'escuela'),
                )
            ) ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'search';
    }
}
