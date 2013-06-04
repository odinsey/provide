<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Resources
 *
 * @ORM\Table("resources")
 * @ORM\Entity(repositoryClass="ResourcesRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Resources {

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
	 * @var extension
	 *
	 * @ORM\Column(name="extension", type="text")
	 */
	private $extension;
	/**
	 * @var path
	 *
	 * @ORM\Column(name="path", type="text")
	 */
	private $path;
	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="published", type="boolean")
	 */
	private $published = false;
    
	/**
	 * @Gedmo\SortablePosition
	 * @ORM\Column(name="position", type="integer")
	 */
	private $position;
	/**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="resources")
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 *
	 * @var Category
	 */
	private $category;
	/**
	 * @Assert\File(maxSize="5M", mimeTypes = {"application/pdf", "application/x-pdf"})
	 *
	 * @var File $file
	 */
	private $file;

	/*
	 * @return string
	 */

	public function __toString() {
		return $this->title.' ('.$this->path.')';
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

	/**
	 * Get published
	 *
	 * @return boolean
	 */
	public function isPublished() {
		return $this->published ? true : false;
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
	 * @return Resources
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
	 * @return Resources
	 */
	public function setDescription($description) {
		$this->description = $description;

		return $this;
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
	 * Set category
	 *
	 * @param Category $category
	 * @return Category
	 */
	public function setCategory($category = null) {
		$this->category = $category;

		return $this;
	}

	/**
	 * Get category
	 *
	 * @return Category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Set position
	 *
	 * @param integer $position
	 * @return Resources
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
	 * Set file
	 *
	 * @param mixed $file
	 */
	public function setFile($file) {
		if($file != $this->file){
			$this->updated_at = new \DateTime();
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
		return $this->getWebPath().'/'.$this->getPath();
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload() {
		if(null !== $this->file){
			$this->extension = $this->file->guessExtension();
			$this->path = $this->file->getClientOriginalName();
			if(!is_dir($this->getFilePath())){
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
		if(null === $this->file){
			return;
		}
		$this->extension = $this->file->guessExtension();
		$this->path = $this->file->getClientOriginalName();
		$this->file->move($this->getFilePath(),$this->file->getClientOriginalName());

		unset($this->file);
	}

	/**
	 * @ORM\PreRemove()
	 */
	public function removeUpload() {
		$filesystem = new Filesystem();
		$filesystem->remove($this->getFilePath().'/'.$this->getFileName());
	}

	public function getFileName() {
		return $this->path;
	}

	public function getAbsolutePath() {
		return $this->getFilePath().'/'.$this->getFileName();
	}

	public function getWebPath() {
		return $this->getUploadDir();
	}


	public function getPath() {
		return $this->getFilePath().'/'.$this->getFileName();
	}

	public function getFilePath() {
		return $this->getUploadRootDir();
	}

	protected function getUploadRootDir() {
		return __DIR__.'/../../../../../www'.$this->getUploadDir();
	}

	protected function getUploadDir() {
		return '/upload/resources';
	}

}
