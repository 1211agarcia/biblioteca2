<?php

namespace Biblioteca\TegBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * keyWordType
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 2/12/2015
 */
class keyWordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyWord', 'text', 
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'label' => 'Palabra clave',
                    'attr'=> array('class' => 'form-control',
                                    'placeholder' => 'Palabra clave'),
                )
            );

    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Biblioteca\TegBundle\Entity\keyWord'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'biblioteca_tegbundle_keyWord';
    }
}