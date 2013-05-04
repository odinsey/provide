<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * News
 *
 * @ORM\Table("news")
 * @ORM\Entity(repositoryClass="NewsRepository")
 */
class News {
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
     * @ORM\Column(type="integer")
     */
    protected $revision = 0;
    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="revisions")
     * @ORM\JoinColumn(name="master_id")
     *
     * @var News
     */
    protected $master;


    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="master")
     *
     * @var ArrayCollection
     */
    protected $revisions;

    /**
     * @ORM\ManyToMany(targetEntity="Picture", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="news_picture",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $pictures;

    public function __construct() {
        $this->pictures = new ArrayCollection();
        $this->revisions = new ArrayCollection();
    }

    /*
     * @return string
     */
    public function __toString() {
        return (string) $this->title;
    }

    public function __clone() {
        $this->master = $this->id;
        $this->id = null;
    }
    /**
     * Add revision
     *
     * @param \NP\Bundle\ModuloBundle\Entity\News $revision
     */
    public function addRevision(News $revision) {
        if (!$this->revisions->contains($revision)) {
            $revision->setMaster($this);
            $this->revisions->add($revision);
        }
    }

    /**
     * Remove revision
     *
     * @param \NP\Bundle\ModuloBundle\Entity\News $revision
     */
    public function removeRevision(News $revision) {
        if ($this->revisions->contains($revision)) {
            $this->revisions->removeElement($revision);
        }
    }

    public function getRevisions()
    {
        return $this->revisions;
    }

    public function setMaster($master){
        $this->master = $master;

        return $this;
    }

    public function getMaster(){
        return $this->master;
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
     * Sets position.
     *
     * @param  Integer $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Returns position.
     *
     * @return Integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets revision.
     *
     * @param  Integer $revision
     * @return $this
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Returns revision.
     *
     * @return Integer
     */
    public function getRevision()
    {
        return $this->revision;
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
     * @param \NP\Bundle\ModuloBundle\Entity\Picture $picture
     */
    public function addPicture(Picture $picture) {
        if (!$this->pictures->contains($picture)) {
			$picture->setParent($this);
            $this->pictures->add($picture);
        }
    }

    /**
     * Remove picture
     *
     * @param \NP\Bundle\ModuloBundle\Entity\Picture $picture
     */
    public function removePicture(Picture $picture) {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
        }
    }

}
