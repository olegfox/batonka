<?php

namespace Site\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Site\MainBundle\Entity\Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="Site\MainBundle\Entity\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"title", "id"})
     * @ORM\Column(length=128)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=500, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=500, nullable=true)
     */
    private $metaKeywords;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @Assert\File()
     */
    private $file;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Список фото из формы
     **/
    protected $gallery;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getAbsolutePath()
    {
        return null === $this->img
            ? null
            : $this->getUploadRootDir().'/'.$this->img;
    }

    public function getWebPath()
    {
        return null === $this->img
            ? null
            : $this->getUploadDir().'/'.$this->img;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../../'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/photo';
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        $this->upload();
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        if (isset($this->img)) {
            if(file_exists($this->getUploadDir().'/'.$this->img)){
                unlink($this->getUploadDir().'/'.$this->img);
            }
            $this->img = null;
        }

        $this->img = uniqid() . '.' . $this->getFile()->guessClientExtension();

        $this->getFile()->move(
            $this->getUploadDir(),
            $this->img
        );

        $this->file = null;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set img
     *
     * @param string $img
     * @return Photo
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Photo
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Photo
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
     * Set slug
     *
     * @param string $slug
     * @return Photo
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     * @return Photo
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return Photo
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return Photo
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Photo
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
}
