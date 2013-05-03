<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Step
 *
 * @ORM\Table("step")
 * @ORM\Entity(repositoryClass="StepRepository")
 */
class Step {
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
    private $published = 0;


    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="steps", cascade={"all"} )
     * @ORM\JoinColumn(onDelete="SET NULL")
     *
     * @var Event
     */
    private $event;

    /**
     * @ORM\ManyToMany(targetEntity="Picture", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="step_picture",
     *      joinColumns={@ORM\JoinColumn(name="step_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
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
        $picture->setParent($this);
	if (!$this->pictures->contains($picture) ) {
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
    public function setEvent($event = null) {
	$this->event = $event;

	return $this;
    }

    /**
     * Get Event
     *
     * @return Event
     */
    public function getEvent() {
	return $this->event;
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
