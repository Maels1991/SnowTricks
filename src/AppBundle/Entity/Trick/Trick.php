<?php

namespace AppBundle\Entity\Trick;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trick
 *
 * @ORM\Table(name="trick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Trick\TrickRepository")
 *
 * @UniqueEntity("name", message="Ce nom de figure est déjà utilisé")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Trick
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Le nom de la figure ne peut être vide")
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="introduction", type="text")
     *
     * @Assert\NotBlank(message="Veuillez nous parler de cette figure")
     */
    private $introduction;

    /**
     * @var null|\AppBundle\Entity\Trick\Family
     *
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="tricks")
     * @ORM\JoinColumn(name="family", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull(message="Une figure doit appartenir à un groupe. Si le groupe n'existe pas, vous pouvez le créer.")
     */
    private $family;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="trick", cascade={"persist", "remove"})
     *
     * @Assert\Valid()
     * @Assert\Count(min="1", minMessage="Veuillez illustrer votre figure avec au moins 1 image")
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="trick", cascade={"persist", "remove"})
     *
     * @Assert\Valid()
     * @Assert\Count(min="1", minMessage="Veuillez lier une vidéo à votre figure")
     */
    private $videos;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="trick")
     */
    private $comments;

    /**
     * @var
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * Trick constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->videos = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Trick
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     *
     * @return Trick
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * @return null|Family
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param null|Family $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param \AppBundle\Entity\Trick\Image $image
     *
     * @return $this
     */
    public function addImage(Image $image)
    {
        $image->setTrick($this);

        $this->getImages()->add($image);

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Trick\Image $image
     *
     * @return $this
     */
    public function removeImage(Image $image)
    {
        $this->getImages()->removeElement($image);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param \AppBundle\Entity\Trick\Video $video
     *
     * @return $this
     */
    public function addVideo(Video $video)
    {
        $video->setTrick($this);

        $this->getVideos()->add($video);

        return $this;
    }

    /**
     * @param \AppBundle\Entity\Trick\Video $video
     *
     * @return $this
     */
    public function removeVideo(Video $video)
    {
        $this->getVideos()->removeElement($video);

        return $this;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ?\Doctrine\ORM\PersistentCollection
     *
     * Pas besoin d'ajouter addComment / removeComment
     * Ces méthodes ne sont nécessaires que dans le cas où on
     * souhaite intervenir dans le processus da
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @ORM\PostLoad()
     */
    public function updatedAt()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
