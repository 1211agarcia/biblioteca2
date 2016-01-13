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
                                   'ng-required'=>'isInvalid()',
                                   'class' => 'form-control'),
                )
            )
            ->add('submit', 'submit', 
                array('label'=> 'Buscar',
                    'attr'=> array('class' => 'btn btn-primary','value'=> 'Buscar','ng-disabled'=> 'isInvalid()', 'ng-click' => 'load($event)', 'ng-model' => 'loadingSubmit', 'disabler'=>'Buscando'))
            )
            ->add('desde', 'date',
                array(
                    //'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control', 'min'=>"1998-01-01", 'max'=>date('Y')."-".date('m')."-".date('d'), 'ng-model'=>'desde'),
                    'widget' => 'single_text')
            )
            ->add('hasta', 'date',
                array(
                    //'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control', 'min'=>"[[desde]]", 'max'=>date('Y')."-".date('m')."-".date('d')),
                    'widget' => 'single_text')
            )
            ->add('escuela', 'choice',
                array(
                    'empty_value' => 'Cualquier escuela',
                    'choices'  => teg::getSchools(),
                    'required' => false,
                    'label' => false,
                    'attr'=> array('ng-model'=>'escuela',
                                   'class' => 'form-control'),
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
