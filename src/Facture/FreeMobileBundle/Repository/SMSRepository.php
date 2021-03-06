<?php

namespace Facture\FreeMobileBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SMSRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SMSRepository extends EntityRepository
{
	public function findSMSNb()
	{
		$query = $this->_em->createQuery('SELECT COUNT(s) FROM FactureFreeMobileBundle:SMS s');
		return $query->getResult();
	}
	
	public function findDateFirstSMS($id)
	{
		$query = $this->_em->createQuery('SELECT s.date FROM FactureFreeMobileBundle:SMS s WHERE s.contact = :id ORDER BY s.id ASC');
		$query->setParameter('id', $id);
		$query->setMaxResults(1);
		$query->setFirstResult(0);
		return $query->getResult();
	}
	
	public function findDateLastSMS($id)
	{
		$query = $this->_em->createQuery('SELECT s.date FROM FactureFreeMobileBundle:SMS s WHERE s.contact = :id ORDER BY s.id DESC');
		$query->setParameter('id', $id);
		$query->setMaxResults(1);
		$query->setFirstResult(0);
		return $query->getResult();
	}
}
