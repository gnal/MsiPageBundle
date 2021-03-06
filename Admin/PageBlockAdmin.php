<?php

namespace Msi\Bundle\PageBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;
use Doctrine\ORM\EntityRepository;

class PageBlockAdmin extends Admin
{
    public function configure()
    {
        $this->options = array(
            'search_fields' => array('type', 'name'),
            'controller' => 'MsiPageBundle:PageBlock:',
        );
    }

    public function buildIndexTable($builder)
    {
        $builder
            ->add('enabled', 'boolean', array('label' => 'status'))
        ;

        if ($this->getContainer()->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            $builder->add('isSuperAdmin', 'boolean');
        }

        $builder
            ->add('name')
            ->add('pages', 'collection')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder->add('name');

        $typeId = $this->getObject()->getType();
        if ($typeId) {
            $blockType = $this->container->get($typeId);
            $blockType->buildForm($builder);
            $builder->add('pages', 'entity', array('multiple' => true, 'expanded' => true, 'class' => 'MsiPageBundle:Page'));
        } else {
            $builder
                ->add('type', 'choice', array(
                    'choices' => array(
                        'msi_block.block.text.type' => 'Text',
                        'msi_block.block.action.type' => 'Action',
                        'msi_block.block.template.type' => 'Template',
                    ),
                ))
            ;
        }
    }

    public function buildFilterForm($builder)
    {
        $builder->add('pages', 'entity', array(
            'class' => 'MsiPageBundle:Page',
            'label' => ' ',
            'empty_value' => '- '.$this->container->get('translator')->transchoice('entity.Page', 1).' -',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('a')
                    ->leftJoin('a.translations', 't')
                    ->addSelect('t')
                ;
            },
        ));
    }
}
