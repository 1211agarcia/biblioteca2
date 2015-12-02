<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * tuthorType
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 2/12/2015
 */
class tuthorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'label' => 'Nombre',
                    'attr'=> array('class' => 'form-control',
                                    'placeholder' => 'Nombre'),
                )
            )
            ->add('lastname', 'text', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'label' => 'Apellido',
                    'attr'=> array('class' => 'form-control',
                                    'placeholder' => 'Apellido'),
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
            'data_class' => 'Biblioteca\TegBundle\Entity\tuthor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'biblioteca_tegbundle_tuthor';
    }
}