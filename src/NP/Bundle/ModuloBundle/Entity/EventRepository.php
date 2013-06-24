<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Cms\Bundle\AdminBundle\Entity\Traits\BaseAdminEntityRepository;
use Cms\Bundle\AdminBundle\Entity\Traits\SortableRepository;
use Cms\Bundle\AdminBundle\Entity\Traits\PublishableRepository;
use Gedmo\Sortable\Entity\Repository\SortableRepository as gSortableRepository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends gSortableRepository {
    use BaseAdminEntityRepository;
    use SortableRepository;
    use PublishableRepository;
	
    public function findAllInScholarYear(){
	$qb = $this->createQueryBuilder('a');
	$qb = $this->whereCurrentYear($qb);
	return	$qb->getQuery()->getResult();
    }
    
    public function whereCurrentYear(\Doctrine\ORM\QueryBuilder $qb)
    {
	$year = (date('n',time()) < 7) ? date('Y',time()) - 1 : date('Y',time());

	$qb->andWhere('a.start BETWEEN :debut AND :fin')
	    ->setParameter('debut', new \Datetime($year.'-08-01'))  // Date entre le 1er aout de cette année scolaire
	    ->setParameter('fin',   new \Datetime(($year+1).'-07-31')); // Et le 31 juillet de cette année scolaire

	return $qb;
    }
    public function findAllArchives(){
	$qb = $this->createQueryBuilder('a');
	$qb = $this->whereOlder($qb);
	return	$qb->getQuery()->getResult();
    }
    
    public function whereOlder(\Doctrine\ORM\QueryBuilder $qb)
    {
	$year = (date('n',time()) < 7) ? date('Y',time()) - 1 : date('Y',time());

	$qb->andWhere('a.start < :debut')
	    ->setParameter('debut', new \Datetime($year.'-08-01'));  // Date avant le 1er aout de cette année scolaire

	return $qb;
    }
}
