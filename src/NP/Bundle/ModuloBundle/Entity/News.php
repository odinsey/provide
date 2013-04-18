<?php

namespace NP\Bundle\ModuloBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * News
 *
 * @ORM\Table("news", uniqueConstraints={
 *  @ORM\UniqueConstraint(name="versionnable_idx", columns={"id", "revision"})})
 * @ORM\Entity(repositoryClass="NewsRepository")
 * @ORM\HasLifecycleCallbacks
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
    private $published;

    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Version
     */
    protected $revision;

    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="news")
     */
    private $newsLog = array();

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="newsLog")
     */
    private $news;

    /**
     * @ORM\ManyToMany(targetEntity="Picture", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinTable(name="news_picture",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="picture_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $pictures;

    public function __construct($news = null) {
        $this->pictures = new ArrayCollection();
        $this->newsLog = new ArrayCollection();
        $this->revision = 0;
        if( $news instanceof News ){
            $this->news = $news;
            $this->title = $news->getTitle();
            $this->description = $news->getDescription();
            $this->revision = $news->getRevision();
            $this->position = $news->getPosition();
            $this->published = $news->getPublished();
            $this->pictures = $news->getPictures();
        }
    }

    public function __clone() {
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function oldVersion()
    {
        $this->newsLog[] = new News($this);
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
        $picture->setParent($this);
        if (!$this->pictures->contains($picture)) {
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
