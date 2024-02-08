<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Comment;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource()]
#[Vich\Uploadable]
/**
 * @SuppressWarnings(PHPMD)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    // test en implémentant la partie artiste

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Artwork::class,
        cascade:['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $artworks;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[Vich\UploadableField(mapping: 'user_poster', fileNameProperty: 'poster')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/svg'],
        mimeTypesMessage: 'Please upload a valid image file'
    )]
    private ?File $posterFile = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->artworks = new ArrayCollection();
        $this->expos = new ArrayCollection();
    }

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $facebookId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudonym = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: Artwork::class, inversedBy: 'favoritedBy')]
    private Collection $favorites;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $hostedDomain = null;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Expo::class,
        cascade:['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $expos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster = null): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getArtworks(): Collection
    {
        return $this->artworks ;
    }

    public function addArtwork(Artwork $artwork): static
    {
        {
        if (!$this->artworks->contains($artwork)) {
            $this->artworks[] = $artwork;
            $artwork->setUser($this);
        }

            return $this;
        }
    }

    public function removeArtwork(Artwork $artwork): self
    {

        if ($this->artworks->contains($artwork)) {
            $this->artworks->removeElement($artwork);
            // set the owning side to null (unless already changed)
            if ($artwork->getUser() === $this) {
                $artwork->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of posterFile
     */
    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    /**
     * Set the value of posterFile
     *
     * @return  self
     */
    public function setPosterFile(File $posterFile = null): User
    {
        $this->posterFile = $posterFile;
        if ($posterFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password ?? '';
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        //$this->currentPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPseudonym(): ?string
    {
        return $this->pseudonym;
    }

    public function setPseudonym(string $pseudonym): static
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Artwork>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Artwork $artwork): static
    {
        if (!$this->favorites->contains($artwork)) {
            $this->favorites->add($artwork);
        }
        return $this;
    }

    public function removeFavorite(Artwork $artwork): static
    {
        $this->favorites->removeElement($artwork);

        return $this;
    }

     /** Get the value of hostedDomain
     * @return string
     */
    public function getHostedDomain(): string
    {
        return $this->hostedDomain;
    }

    /**
     * Set the value of hostedDomain
     * @param string $hostedDomain
     * @return $this
     *
     */
    public function setHostedDomain(string $hostedDomain): static
    {
        $this->hostedDomain = $hostedDomain;

        return $this;
    }

    /**
     * Get the value of avatar
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return static
     */
    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Expo>
     */
    public function getExpos(): Collection
    {
        return $this->expos;
    }

    public function addExpo(Expo $expo): static
    {
        if (!$this->expos->contains($expo)) {
            $this->expos->add($expo);
            $expo->setUser($this);
        }

        return $this;
    }

    public function removeExpo(Expo $expo): static
    {
        if ($this->expos->removeElement($expo)) {
            // set the owning side to null (unless already changed)
            if ($expo->getUser() === $this) {
                $expo->setUser(null);
            }
        }

        return $this;
    }
}
