<?php
/**
 * Tea entity.
 */

namespace App\Entity;

use App\Repository\TeaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tea.
 */
#[ORM\Entity(repositoryClass: TeaRepository::class)]
#[ORM\Table(name: 'teas')]
#[UniqueEntity(fields: ['title'], message: 'message.tea_entity.not_unique')]
class Tea
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Created at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt;

    /**
     * Updated at.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt;

    /**
     * Title.
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title;

    /**
     * Category.
     *
     * @var Category|null
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category;

    /**
     * Tags.
     *
     * @var Collection<int, Tag>|null
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Tag::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'teas_tags')]
    private ?Collection $tags;

    /**
     * Author.
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank]
    #[Assert\Type(User::class)]
    private ?User $author;

    /**
     * Description.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Type('string')]
    private ?string $description = null;

    /**
     * Ingredients.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ingredients = null;

    /**
     * Steep Time in seconds.
     */
    #[ORM\Column(nullable: true)]
    private ?int $steepTime = null;

    /**
     * Steep temperature in Celsius.
     *
     * @var int|null
     */
    #[ORM\Column(nullable: true)]
    private ?int $steepTemp = null;

    /**
     * Region of origin.
     */
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $region = null;

    /**
     * Vendor/Store.
     */
    #[ORM\Column(length: 64, nullable: true)]
    private ?string $vendor = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Comments.
     */
    #[ORM\OneToMany(mappedBy: 'tea', targetEntity: Comment::class, orphanRemoval: true)]
//    #[ORM\JoinColumn(nullable: true)]
    private ?Collection $comments = null;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for created at.
     *
     * @return \DateTimeImmutable|null Created at
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     *
     * @param \DateTimeImmutable $createdAt Created at
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for updated at.
     *
     * @return \DateTimeImmutable|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updated at.
     *
     * @param \DateTimeImmutable $updatedAt Updated at
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for category.
     *
     * @return Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for tags.
     *
     * @return Collection<int, Tag> Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag.
     *
     * @param Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag.
     *
     * @param Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Getter for author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author.
     *
     * @param User|null $author
     *
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Getter for description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     *
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Getter for ingredients.
     *
     * @return string|null
     */
    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    /**
     * Getter for ingredients.
     *
     * @param string|null $ingredients
     *
     * @return $this
     */
    public function setIngredients(?string $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Getter for steep time.
     *
     * @return int|null
     */
    public function getSteepTime(): ?int
    {
        return $this->steepTime;
    }

    /**
     * Setter for steep time.
     *
     * @param int|null $steepTime steep time
     *
     * @return $this
     */
    public function setSteepTime(?int $steepTime): self
    {
        $this->steepTime = $steepTime;

        return $this;
    }

    /**
     * Getter for steep temperature.
     *
     * @return int|null
     */
    public function getSteepTemp(): ?int
    {
        return $this->steepTemp;
    }

    /**
     * Setter for steep temperature.
     *
     * @param int|null $steepTemp
     *
     * @return $this
     */
    public function setSteepTemp(?int $steepTemp): self
    {
        $this->steepTemp = $steepTemp;

        return $this;
    }

    /**
     * Getter for region.
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * Setter for region.
     *
     * @param string|null $region
     *
     * @return $this
     */
    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Getter for vendor.
     *
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    /**
     * Setter for vendor.
     *
     * @param string|null $vendor
     *
     * @return $this
     */
    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Getter for Comments collection.
     *
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Adding another comment.
     *
     * @param Comment $comment comment
     *
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTea($this);
        }

        return $this;
    }

    /**
     * Removing one of the comments.
     *
     * @param Comment $comment comment
     *
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTea() === $this) {
                $comment->setTea(null);
            }
        }

        return $this;
    }
}
