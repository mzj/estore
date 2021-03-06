<?php
/**
 * 
 */
namespace eStore\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    Gedmo\Mapping\Annotation as Gedmo;

/**
 * eStore\ShopBundle\Entity\Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="eStore\ShopBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    
    const STATUS_ENABLED    = true;
    const STATUS_DISABLED   = false;
    
    const GENDER_M = 1;
    const GENDER_W = 2;
    const GENDER_K = 3;
    const GENDER_U = 4;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;
    
    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var decimal $price
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    
    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = self::STATUS_DISABLED;
    
    /**
     * @var string $imageName
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     *
     * @var type 
     */
    public $file;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @ORM\JoinTable(name="category_product",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   }
     * )
     */
    private $categories;
    
    /**
     * @ORM\Column(name="gender", type="integer")
     */
    private $gender;

    /**
     *
     * @ORM\OneToMany(targetEntity="Garment", mappedBy="product", cascade={"all"},orphanRemoval=true)
     */
    private $garments;
   
    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="product")
     */
    private $orders;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="products")
     */
    private $brand;
    
    /**
     * 
     */
    public function __construct()
    {
        // When creating entity as POPO
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->categories = new ArrayCollection();
    }

    /**
     * @ORM\prePersist
     */
    public function setCreatedValue()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }
    
    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set name
     *
     * @param string $name
     */
    public function setGender($gender)
    {
        if (!in_array($gender, array(self::GENDER_M, self::GENDER_W, self::GENDER_K, self::GENDER_U))) {
            throw new \InvalidArgumentException("Invalid gender value");
        }
        $this->gender = $gender;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImageName($image)
    {
        $this->imageName = $image;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    
    
        /**
* Add categories
*
* @param MZJ\YabBundle\Entity\Category $categories
* @return Post
*/
    public function addCategorie(\eStore\ShopBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
* Remove categories
*
* @param MZJ\YabBundle\Entity\Category $categories
*/
    public function removeCategorie(\eStore\ShopBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
* Get categories
*
* @return Doctrine\Common\Collections\Collection
*/
    public function getCategories()
    {
        return $this->categories;
    }
    
    
    public function removeCategories() 
    {
        foreach($this->categories as $cat) {
            $this->categories->removeElement($cat);
        }
    }
    /**
* Add categories
*
* @param MZJ\YabBundle\Entity\Category $categories
* @return Post
*/
    public function setCategories($categories)
    {
        $this->categories = $categories;
    
        return $this;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    /**
     * Add categories
     *
     * @param eStore\ShopBundle\Entity\Category $categories
     */
    /*public function addCategory(\eStore\ShopBundle\Entity\Category $category)
    {
        //$category->addProduct($this);
        $this->categories[] = $category;
    }*/


    
    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    /*public function getCategories()
    {
        return $this->categories;
    }*/
    
    
    

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getGarments()
    {
        return $this->garments;
    }
    
    /**
     */
    public function setGarments($garments)
    {
        $this->garments = $garments;
        foreach ($garments as $garment){
            $garment->setProduct($this);
        }
    }
    
    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    

    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $this->removeUpload();
            $this->imageName = $this->file->getClientOriginalName();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->file->move($this->getUploadRootDir(),  $this->id . '-' . $this->file->getClientOriginalName());

        unset($this->file);
    }

    /**
     * PostRemove event can not be used here.  
     * Id value is deleted before we could use 
     * it to delete a coresponding file
     * 
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            if(file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->imageName ? null : $this->getUploadRootDir() . '/' . $this->id . '-' . $this->imageName;
    }
    

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/products';
    }

    /**
     * Add garments
     *
     * @param eStore\ShopBundle\Entity\Garment $garments
     */
    public function addGarment(\eStore\ShopBundle\Entity\Garment $garments)
    {
        $this->garments[] = $garments;
    }

    /**
     * Set brand
     *
     * @param eStore\ShopBundle\Entity\Brand $brand
     */
    public function setBrand(\eStore\ShopBundle\Entity\Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Get brand
     *
     * @return eStore\ShopBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }
}