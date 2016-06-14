<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', null, array(
                'required' => false,
                'label' => 'backend.menu.position',
                'attr' => array(
                    'min' => 0
                )
            ))
            ->add('parent', 'entity', array(
                'required' => false,
                'label' => 'backend.menu.parent',
                'class' => 'Site\MainBundle\Entity\Menu'
            ))
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'backend.menu.title'
            ))
            ->add('page', 'entity', array(
                'required' => false,
                'label' => 'backend.menu.page',
                'class' => 'Site\MainBundle\Entity\Page'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Menu',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_menu';
    }
}
