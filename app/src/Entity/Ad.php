<?php
/**
 * License block.
 */

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Entity for Ad.
 */
#[ORM\Entity(repositoryClass: AdRepository::class)]
#[ORM\Table(name: 'ads')]
class Ad
{
    /**
     * Constructor for Ad, sets approved as false.
     */
    public function __construct()
    {
        $this->approved = false;
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?bool $approved = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $email = null;

    /** Getter for ID.
     * @return int|null ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** Getter for createdAt.
     * @return \DateTimeInterface|null when was the ad created
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /** Setter for createdAt.
     * @param \DateTimeInterface $createdAt new creation date
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /** Getter for updated at.
     * @return \DateTimeInterface|null whether and when was the record last updated
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /** Setter for updatedAt.
     * @param \DateTimeInterface $updatedAt last update time
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /** Getter for Title.
     * @return string|null title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title new title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /** Getter for category.
     * @return Category|null category of this ad
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /** Setter for category.
     * @param Category|null $category category
     *
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return bool|null whether it is approved
     */
    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    /** Setter for Approved.
     * @param bool $approved whether ad is approved
     *
     * @return $this
     */
    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    /** Getter for Content.
     * @return string|null content of the ad
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /** Setter for Content.
     * @param string|null $content new content
     *
     * @return $this
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /** Getter for Email.
     * @return string|null email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /** Setter for Email.
     * @param string|null $email email
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
