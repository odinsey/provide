<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Imagine\Image\ImageInterface;

/**
 * Picture
 *
 * @ORM\Table("picture")
 * @ORM\Entity(repositoryClass="PictureRepository")
 */
class Picture {
    use TimestampableEntity;

    public static $FILE_TYPES = array(
	'small' => array('type'=>'thumbnail','width' => 90, 'height' => 78, 'thumbnail_type' => ImageInterface::THUMBNAIL_OUTBOUND),
	'thumb1' => array('type'=>'thumbnail','width' => 146, 'height' => 82, 'thumbnail_type' => ImageInterface::THUMBNAIL_OUTBOUND),
        'thumb2' => array('type'=>'thumbnail','width' => 121, 'height' => 83, 'thumbnail_type' => ImageInterface::THUMBNAIL_OUTBOUND),
	'big' => array('type'=>'relative_resize', 'width' => 1024, 'height' => 768)
    );

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
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position = 0;

    /**
     * @Assert\File(maxSize="5M")
     * @Assert\Image()
     */
    private $file;

    /**
     * @var path
     *
     * @ORM\Column(name="path", type="text", nullable=true)
     */
    private $path;

    /**
     * Not persisted
     * @var parent
     *
     */
    private $parent;

    /*
     * @return string
     */
    public function __toString() {
		return $this->title ? $this->title : $this->path.'.'.$this->extension;
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
     * Set title
     *
     * @param string $title
     * @return Picture
     */
    public function setTitle($title) {
	$this->title = $title;

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
     * Set position
     *
     * @param integer $position
     * @return Picture
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
	if ($file != null) {
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
	
    public function setPath($path){
        $this->path = $path;
    }
    public function getPath($type=null){
        return $type ? str_replace('##TYPE##', $type, $this->path) : $this->path;
    }
    public function getWebPath(){
        return ltrim($this->path,'/');
    }

    public function getParent(){
        return $this->parent;
    }

    public function setParent($parent){
        $this->parent = $parent;
    }


/******************************************************************************
 *                          UPLOAD FILE PART
 */
    public function buildPath(){
		$this->path = '/upload/'.$this->getFolderName().'/'.$this->getFileName();
		if ($this->parent instanceof Step) {
			$this->path = str_replace('/upload/', '/upload/sortie-'.$this->parent->getEvent()->getId().'/', $this->path);
		}
    }

    public function getFileName() {
		return sprintf('img-%s-%d.%s', '##TYPE##', $this->id, $this->getFile()->getClientOriginalExtension());
    }

    public function getFolderName() {
        $class = explode('\\',get_class($this->getParent()));
		return sprintf('%s-%d', strtolower(end($class)), $this->getParent()->getId());
    }

}