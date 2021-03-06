<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class documentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder/*
            ->add('name', 'text',
            array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control'),
                    'required' => true,
                    'read_only' => true,
                )
            )*/
            ->add('file', 'file',
            array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'label' => false,
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
            'data_class' => 'Biblioteca\TegBundle\Entity\documento',
            //'csrf_protection' => false,
            'documento_class'    => 'Biblioteca\TegBundle\Entity\documento',
            'documento_form'     => new documentoType(),
        ));
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'biblioteca_tegbundle_documento';
    }
}
