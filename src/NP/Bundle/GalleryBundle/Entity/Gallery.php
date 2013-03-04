<?php

namespace NP\Bundle\GalleryBundle\Entity;


use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Gallery
 *
 * @ORM\Table("gallery")
 * @ORM\Entity(repositoryClass="NP\Bundle\GalleryBundle\Entity\GalleryRepository")
 */
class Gallery {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="parent", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $pictures;

    public function __construct() {
	$this->pictures = new ArrayCollection();
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished() {
	return $this->published;
    }

    /**
     * Set published
     *
     * @return boolean
     */
    public function setPublished($published) {
	$this->published = $published;
    }

    /*
     * @return string
     */
    public function __toString() {
	return $this->title;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Gallery
     */
    public function setTitle($title) {
	$this->title = $title;

	return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Gallery
     */
    public function setDescription($description) {
	$this->description = $description;

	return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Gallery
     */
    public function setPosition($position) {
	$this->position = $position;

	return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition() {
	return $this->position;
    }

    /**
     * Get pictures
     *
     * @return array_collection
     */
    public function getPictures() {
		return $this->pictures;
    }

    /**
     * Add picture
     *
     * @param \NP\Bundle\GalleryBundle\Entity\Picture $picture
     */
    public function addPicture(Picture $picture) {
	if (!$this->pictures->contains($picture) && $picture->getFile() ) {
            $picture->setParent($this);
	    $this->pictures->add($picture);
	}
    }

    /**
     * Remove picture
     *
     * @param \NP\Bundle\GalleryBundle\Entity\Picture $picture
     */
    public function removePicture(Picture $picture) {
	if ($this->pictures->contains($picture)) {
	    $this->pictures->removeElement($picture);
	}
    }

}
