<?php

namespace Facture\FreeMobileBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SMSAdmin extends Admin
{
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
			->add('id')
            ->add('contact')
            ->add('date')
            ->add('origine')
            ->add('quantite')
            ->add('cout')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('MMS')
				->add('id')
				->add('contact')
				->add('date')
				->add('origine')
				->add('quantite')
				->add('cout')
            ->end()
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
			->addIdentifier('id')
            ->add('contact')
            ->add('date')
            ->add('origine')
            ->add('quantite')
            ->add('cout')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
			->add('id')
            ->add('contact')
            ->add('date')
            ->add('origine')
            ->add('quantite')
            ->add('cout')
        ;
    }
}
