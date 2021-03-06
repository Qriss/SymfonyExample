<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Auction
 *
 * @ORM\Table(name="auction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AuctionRepository")
 */
class Auction
{

    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finisged";
    const STATUS_CANCELLED = "cancelled";
    /**
     * @var int
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
     * @Assert\NotBlank(
     *     message="Tytul nie moze byc pusty"
     * )
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Tytul nie moze byc krotszy niz 3 znaki",
     *     maxMessage="Tytul nie moze byc dluzszy niz 255 znakow"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(
     *     message="Opis nie moze byc pusty"
     *)
     * @Assert\Length(
     *     min=10,
     *     minMessage="Opis musi miec wiecej niz 10 znaki"
     * )
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *     message="Cena nie moze byc pusta"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Cena musi byc wyzsz od 0"
     * )
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="string_price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *     message="Cena wywolawcza nie moze byc pusta"
     *)
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Cena musi byc wyzsz od 0"
     * )
     */
    private $startingPrice;


    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createAt", type="datetime")
     */
    private $createAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiresAt", type="datetime")
     *
     * @Assert\NotBlank(
     *     message="musisz podac date zakonczenia aukcji"
     * )
     * @Assert\GreaterThan(
     *     value="+1 day",
     *     message="Aukcja nie moze sie konczyc mniej niz 24 godziny"
     * )
     */
    private $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;
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
     * @var Offer[]
     *
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="auction")
     */
    private $offers;
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="auctions")
     */
    private $owner;

    /**
     * Auction constructor.
     */
    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Auction
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
     * @return Auction
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
     * Set price
     *
     * @param string $price
     *
     * @return Auction
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $startingPrice
     * @return $this
     */
    public function setStartingPrice($startingPrice)
    {
        $this->startingPrice = $startingPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getStartingPrice()
    {
        return $this->startingPrice;
    }

    /**
     * @param \DateTime $createAt
     * @return $this
     */
    public function setCreateAt(\DateTime $createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
    /**
     * @param \DateTime $updateAt
     * @return $this
     */
    public function setUpdateAt(\DateTime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $expiresAt
     * @return $this
     */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param string $expiresAt
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Offer[]|ArrayCollection
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * @param Offer $offer
     * @return $this
     */
    public function addOffer(Offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * @param User $owner
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

}

