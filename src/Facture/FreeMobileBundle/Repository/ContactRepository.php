<?php

namespace Facture\FreeMobileBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ContactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContactRepository extends EntityRepository
{
	public function findContactNb()
	{
		$query = $this->_em->createQuery('SELECT COUNT(c) FROM FactureFreeMobileBundle:Contact c');
		return $query->getResult();
	}
}