<?php

namespace Msi\Bundle\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Msi\Bundle\BlockBundle\Entity\Block as BaseBlock;

/**
 * @ORM\Table(name="page_block")
 * @ORM\Entity
 */
class PageBlock extends BaseBlock
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Page", inversedBy="blocks", cascade={"persist"})
     * @ORM\JoinTable(name="pages_blocks")
     */
    protected $pages;

    public function __construct()
    {
        parent::__construct();
        $this->pages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
