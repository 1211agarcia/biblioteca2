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
            ->add('desde', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                    'label_attr' => array('class' => 'form-control-static'),
                    'attr'=> array('ng-model'=>'desde',
                                   'class' => 'form-control',
                                   'ng-options'=>'n for n in [] | range:1998:'.date('Y')
                                   )
                )
            )
            ->add('hasta', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                    'label_attr' => array('class' => 'form-control-static'),
                    'attr'=> array('ng-model'=>'hasta',
                                   'class' => 'form-control',
                                   'ng-options'=>'n for n in [] | range:fechaMin:'.date('Y')
                                   )
                    )
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
