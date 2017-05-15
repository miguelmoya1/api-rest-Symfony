<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\productRepository")
 */
class product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublished", type="datetime")
     */
    private $datePublished;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="numVisits", type="integer")
     */
    private $numVisits;

    /**
     * @var string
     *
     * @ORM\Column(name="mainPhoto", type="string", length=255)
     */
    private $mainPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="product")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @JMS\Accessor(getter="getIdUser")
     * @JMS\SerializedName("idUser")
     * @JMS\Type("integer")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="category", inversedBy="product")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @JMS\Accessor(getter="getIdCategory")
     * @JMS\SerializedName("idCategory")
     * @JMS\Type("integer")
     */
    private $category;


    public function getIdUser()
    {
        return $this->user->getId();
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getIdCategory()
    {
        return $this->category->getId();
    }

    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed
     * @return product
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="bookmarked", type="boolean")
     */
    private $bookmarked;

    /**
     * @return int
     */
    public function getBookmarked()
    {
        return $this->bookmarked;
    }

    /**
     * @param int $bookmarked
     */
    public function setBookmarked($bookmarked)
    {
        $this->bookmarked = $bookmarked;
    }

    /**
     * product constructor.
     */
    public function __construct()
    {
        $this->datePublished = new \DateTime('now');
        $this->numVisits = 0;
        $this->mainPhoto = 'default.jpg';
        $this->status = 0;
        $this->bookmarked = 0;
        $this->user = new User();
        $this->category = new category();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datePublished
     *
     * @param \DateTime $datePublished
     *
     * @return product
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get datePublished
     *
     * @return \DateTime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set nimVisits
     *
     * @param integer $nimVisits
     *
     * @return product
     */
    public function setNimVisits($nimVisits)
    {
        $this->numVisits = $nimVisits;

        return $this;
    }

    /**
     * Get nimVisits
     *
     * @return int
     */
    public function getNimVisits()
    {
        return $this->numVisits;
    }

    /**
     * Set mainPhoto
     *
     * @param string $mainPhoto
     *
     * @return product
     */
    public function setMainPhoto($mainPhoto)
    {
        $this->mainPhoto = $mainPhoto;

        return $this;
    }

    /**
     * Get mainPhoto
     *
     * @return string
     */
    public function getMainPhoto()
    {
        return $this->mainPhoto;
    }
}

