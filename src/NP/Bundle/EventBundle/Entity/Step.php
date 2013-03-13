<?php

namespace NP\Bundle\EventBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Step
 *
 * @ORM\Table("event_step")
 * @ORM\Entity(repositoryClass="StepRepository")
 */
class Step {
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;


    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="steps")
     * @ORM\JoinColumn(onDelete="SET NULL")
     *
     * @var Event
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="parent", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $pictures;

    public function __construct() {
	$this->pictures = new ArrayCollection();
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
     * Get start
     *
     * @return string
     */
    public function getDate() {
	return $this->date;
    }

    /**
     * Set start
     *
     * @param string $start
     * @return Event
     */
    public function setDate($date) {
	$this->date = $date;

	return $this;
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
     * @return Event
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
     * @return Event
     */
    public function setDescription($description) {
	$this->description = $description;

	return $this;
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
     * @param Picture $picture
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
     * @param Picture $picture
     */
    public function removePicture(Picture $picture) {
	if ($this->pictures->contains($picture)) {
	    $this->pictures->removeElement($picture);
	}
    }

    /**
     * Set Event
     *
     * @param Event $event
     * @return Step
     */
    public function setParent($event = null) {
	$this->parent = $event;

	return $this;
    }

    /**
     * Get Event
     *
     * @return Event
     */
    public function getParent() {
	return $this->parent;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function isPublished() {
	return $this->published ? true : false;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished() {
	return $this->published ? true : false;
    }

    /**
     * Set published
     *
     */
    public function setPublished($published) {
	$this->published = $published;
    }
}
