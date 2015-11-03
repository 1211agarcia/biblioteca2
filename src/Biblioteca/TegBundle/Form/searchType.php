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
                                   'placeholder' => 'Palabra o frase...'),
                )
            )
            ->add('submit', 'submit', 
                array('label'=> 'Buscar')
            )
            ->add('desde', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                )
            )
            ->add('hasta', 'choice',
                array(
                    'choices' => range(1998, date('Y')),
                    'required' => false,
                )
            )
            ->add('escuela', 'choice',
                array(
                    'empty_value' => 'Todas',
                    'choices'  => teg::getSchools(),
                    'required' => false,
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
