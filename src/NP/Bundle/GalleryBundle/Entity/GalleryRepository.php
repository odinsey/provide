<?php

namespace NP\Bundle\GalleryBundle\Entity;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * GalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends SortableRepository {

    public function deleteOne($id)
    {
        $this->deleteGroup(array($id));
    }

    public function deleteGroup($ids)
    {
        $qb = $this->createQueryBuilder('g');

        $qb->delete('NPGalleryBundle:Gallery', 'g')
                ->where($qb->expr()->in('g.id', $ids))
                ->getQuery()
                ->execute();

        $this->_em->flush();
    }
}
