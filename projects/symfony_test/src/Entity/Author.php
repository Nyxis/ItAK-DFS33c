<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $dateOfDeath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'authors')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function getDateOfBirth(): ?\DateTimeImmutable { return $this->dateOfBirth; }
    public function setDateOfBirth(\DateTimeImmutable $dateOfBirth): static { $this->dateOfBirth = $dateOfBirth; return $this; }
    public function getDateOfDeath(): ?\DateTimeImmutable { return $this->dateOfDeath; }
    public function setDateOfDeath(?\DateTimeImmutable $dateOfDeath): static { $this->dateOfDeath = $dateOfDeath; return $this; }
    public function getNationality(): ?string { return $this->nationality; }
    public function setNationality(?string $nationality): static { $this->nationality = $nationality; return $this; }
    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): static { if (!$this->books->contains($book)) { $this->books->add($book); $book->addAuthor($this); } return $this; }
    public function removeBook(Book $book): static { if ($this->books->removeElement($book)) { $book->removeAuthor($this); } return $this; }
} 