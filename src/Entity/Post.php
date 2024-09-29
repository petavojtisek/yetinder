<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Defines the properties of the Post entity to represent the blog posts.
 *
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: 'wjs_post')]
#[UniqueEntity(fields: ['slug'], errorPath: 'name', message: 'post.slug_unique')]
#[ORM\Index(columns: ['gender'], name: 'gender')]
#[ORM\Index(columns: ['zip'], name: 'zip')]
#[ORM\Index(columns: ['slug'], name: 'slug')]
#[ORM\Index(columns: ['published_at'], name: 'published_at')]
#[ORM\Index(columns: ['city'], name: 'city')]
#[ORM\Index(columns: ['width'], name: 'width')]
#[ORM\Index(columns: ['weight'], name: 'weight')]
#[ORM\Index(columns: ['country'], name: 'country')]
#[ORM\Index(columns: ['points'], name: 'points')]

class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    #[Assert\NotBlank]
    private ?string $title = null;



        #[ORM\Column(type: Types::STRING)]
        #[Assert\NotBlank]
        private ?string $name = null;


        #[ORM\Column(type: Types::STRING)]
        #[Assert\Length(max: 10)]
        #[Assert\NotBlank]
        private ?string $gender = null;


        #[ORM\Column(type: Types::FLOAT)]
        private ?float $width = null;


        #[ORM\Column(type: Types::INTEGER)]
        private ?int $weight = null;

        #[ORM\Column(type: Types::STRING, length:255, nullable:true)]
        #[Assert\Length(max: 255)]
        private $image = null;


        #[ORM\Column(type: Types::STRING, nullable:true)]
        #[Assert\Length(max: 255)]
        private ?string $street = null;


        #[ORM\Column(type: Types::STRING, nullable:true)]
        #[Assert\Length(max: 255)]
        private ?string  $city = null;


        #[ORM\Column(type: Types::STRING, nullable:true)]
        #[Assert\Length(max: 20)]
        private ?string $zip  = null;


        #[ORM\Column(type: Types::STRING, nullable:true)]
        #[Assert\Length(max: 100)]
        #[Assert\NotBlank(message: 'post.blank_country')]
        private ?string $country = null;


        #[ORM\Column(type: Types::STRING)]
        private ?string $slug = null;


    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'post.blank_content')]
    #[Assert\Length(min: 10,  minMessage: 'post.too_short_content')]
    #[Assert\Length(max: 255, minMessage: 'post.too_long_content')]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTime $publishedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(type: Types::INTEGER, nullable:true)]
    private ?int $points = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post', orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['publishedAt' => 'DESC'])]
    private Collection $comments;

    private string $imageForWeb;



    public function __construct()
    {
        $this->publishedAt = new \DateTime();
        $this->comments = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }


    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getPublishedAt(): \DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): void
    {
        $comment->setPost($this);
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }
    }

    public function removeComment(Comment $comment): void
    {
        $this->comments->removeElement($comment);
    }


    public function getPoints(){
        return $this->points;
    }

    public function increasePoints($poins){
        $this->points = (int)$this->points + $poins;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function getImage(){
        return $this->image;
    }

    public function setImageForWeb(){
        $this->imageForWeb = null;
    }

    public function getImageForWeb(){
        $img = $this->getImage();
        if(empty($img)){
            $img = "empty-img.jpg";
        }
        return $img;
    }
}
