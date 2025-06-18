<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Editor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'editor', targetEntity: Book::class)]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }
    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): static { if (!$this->books->contains($book)) { $this->books->add($book); $book->setEditor($this); } return $this; }
    public function removeBook(Book $book): static { if ($this->books->removeElement($book)) { if ($book->getEditor() === $this) { $book->setEditor(null); } } return $this; }
} 