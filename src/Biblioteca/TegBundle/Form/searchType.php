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
            ->add('submit', 'submit', 
                array('label'=> 'Buscar',
                    'attr'=> array('class' => 'btn btn-primary','value'=> 'Buscar','ng-disabled'=> '!searchValid', 'ng-click' => 'load($event)', 'ng-model' => 'loadingSubmit', 'disabler'=>'Buscando'))
            )
            ->add('q', 'text', 
                array(
                    'attr'=> array('maxlength' => '200',
                                   'placeholder' => 'Palabra o frase...',
                                   'ng-model'=>'q',
                                   'ng-required' => 'false',
                                   'class' => 'form-control'),
                )
            )
            ->add('desde', 'date',
                array(
                    'attr'=> array('class' => 'form-control', 'ng-required' => 'false', 'min'=>"1998-01-01", 'max'=>date('Y')."-".date('m')."-".date('d'), 'ng-model'=>'desde'),
                    'widget' => 'single_text')
            )
            ->add('hasta', 'date',
                array(
                    
                    'attr'=> array('class' => 'form-control', 'ng-required' => 'false','ng-min'=>"desde", 'max'=>date('Y')."-".date('m')."-".date('d'), 'ng-model'=>'hasta'),
                    'widget' => 'single_text')
            )
            ->add('escuela', 'choice',
                array(
                    'empty_value' => 'Cualquier escuela',
                    'choices'  => teg::getSchools(),
                    'label' => false,
                    'attr'=> array('ng-required' => 'false',
                        'ng-model'=>'escuela','class' => 'form-control'),
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
