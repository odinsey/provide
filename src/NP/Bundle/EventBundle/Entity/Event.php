<?php

namespace NP\Bundle\EventBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NP\Bundle\CoreBundle\Util\Urlizer;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 *
 * @ORM\Table("event")
 * @ORM\Entity(repositoryClass="EventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Event {
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
     * @ORM\Column(name="title", type="string", length=255)
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
     * @ORM\Column(name="state", type="text")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="stop", type="datetime", nullable=true)
     */
    private $stop;

    /**
     * @var extension
     *
     * @ORM\Column(name="extension", type="text", nullable=true)
     */
    private $extension;

    /**
     * @var path
     *
     * @ORM\Column(name="path", type="text", nullable=true)
     */
    private $path;

    /**
     * @Assert\File()
     */
    private $file;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="Step", mappedBy="parent", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"date" = "ASC"})
     */
    protected $steps;

    public function __construct() {
	$this->steps = new ArrayCollection();
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
     * Get state
     *
     * @return string
     */
    public function getState() {
	return $this->state;
    }

    /**
     * Set start
     *
     * @param string $start
     * @return Event
     */
    public function setState($state) {
	$this->state = $state;

	return $this;
    }

    /**
     * Get start
     *
     * @return string
     */
    public function getStart() {
	return $this->start;
    }

    /**
     * Set start
     *
     * @param string $start
     * @return Event
     */
    public function setStart($start) {
	$this->start = $start;

	return $this;
    }


    /**
     * Get stop
     *
     * @return string
     */
    public function getStop() {
	return $this->stop;
    }

    /**
     * Set stop
     *
     * @param string $stop
     * @return Event
     */
    public function setStop($stop) {
	$this->stop = $stop;

	return $this;
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

    /**
     * Get steps
     *
     * @return array_collection
     */
    public function getSteps() {
	return $this->steps;
    }

    /**
     * Add step
     *
     * @param Step $step
     */
    public function addStep(Step $step) {
	if (!$this->steps->contains($step) ) {
            $step->setParent($this);
	    $this->steps->add($step);
	}
    }

    /**
     * Remove step
     *
     * @param Step $step
     */
    public function removeStep(Step $step) {
	if ($this->steps->contains($step)) {
	    $this->steps->removeElement($step);
	}
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension() {
	return $this->extension;
    }

    /**
     * Set description
     *
     * @param string $extension
     * @return Resources
     */
    public function setExtension($extension) {
	$this->extension = $extension;

	return $this;
    }


    /**
     * Set file
     *
     * @param mixed $file
     */
    public function setFile($file) {
	if ($file != $this->file) {
            var_dump($file);
	    $this->updatedAt = new \DateTime();
	    $this->file = $file;
	}
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile() {
	return $this->file;
    }

    /**
     * Get url for a type of image
     *
     * @param string $type
     * @return string
     */
    public function getUrl() {
	return $this->getWebPath() . '/' . $this->getFileName();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
	if (null !== $this->file) {
            $this->extension = $this->file->guessExtension();
            $this->path = $this->file->getClientOriginalName();
	    if (!is_dir($this->getFilePath())) {
		$filesystem = new Filesystem();
		$filesystem->mkdir($this->getFilePath());
	    }
	}
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
	if (null === $this->file) {
	    return;
	}
        $this->extension = $this->file->guessExtension();
        $this->path = $this->file->getClientOriginalName();
	$this->file->move( $this->getFilePath(), $this->file->getClientOriginalName() );

	unset($this->file);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload() {
	$filesystem = new Filesystem();
	$filesystem->remove($this->getFilePath() . '/' . $this->getFileName());
    }


    public function getFileName() {
	return $this->path;
    }

    public function getAbsolutePath() {
	return $this->getFilePath() . '/' . $this->getFileName();
    }

    public function getWebPath() {
	return $this->getUploadDir();
    }

    public function getFilePath() {
	return $this->getUploadRootDir();
    }

    protected function getUploadRootDir() {
	// the absolute directory path where uploaded documents should be saved
	return __DIR__ . '/../../../../../www' . $this->getUploadDir();
    }

    protected function getUploadDir() {
	// get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
	return '/upload/sortie/sortie-'.$this->id;
    }
}
