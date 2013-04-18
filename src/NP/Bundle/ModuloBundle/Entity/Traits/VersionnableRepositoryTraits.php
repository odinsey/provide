<?php

namespace NP\Bundle\ModuloBundle\Entity\Traits;

/**
 * Description of VersionnableRepositoryTraits
 *
 * @author nicolas
 */
class VersionnableRepositoryTraits {

    public function findAll() {
        return $this->findBy(array('revision'=>'MAX'))->groupBy('id');
    }

    public function getLatestRevision() {
        return $this->findBy(array('revision'=>'MAX'))->groupBy('id');
    }

    public function getPublishedRevision() {
        return $this->findBy(array('revision'=>'MAX','published'=>1))->groupBy('id');
    }

}
?>
