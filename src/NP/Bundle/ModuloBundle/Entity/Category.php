<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * News
 *
 * @ORM\Table("resource_category")
 * @ORM\Entity(repositoryClass="CategoryRepository")
 */
class Category {
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
     * @ORM\OneToMany(targetEntity="Resources", mappedBy="category", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "DESC"})
     */
    protected $resources;

    public function __construct() {
        $this->resources = new ArrayCollection();
    }

    /*
     * @return string
     */

    public function __toString() {
        return (string) $this->title;
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
     * @return News
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
     * @return News
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
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
     * Get resources
     *
     * @return array_collection
     */
    public function getResources() {
        return $this->resources;
    }

    /**
     * Add resource
     *
     * @param Resources $resource
     */
    public function addResource(Resources $resource) {
        if (!$this->resources->contains($resource) && $resource->getFile()) {
            $resource->setCategory($this);
            $this->resources->add($resource);
        }
    }

    /**
     * Remove resource
     *
     * @param Resources $resource
     */
    public function removeResource(Resources $resource) {
        if ($this->resources->contains($resource)) {
            $this->resources->removeElement($resource);
        }
    }

}
