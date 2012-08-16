<?php

namespace Msi\Bundle\PageBundle\Entity;

use Msi\Bundle\AdminBundle\Entity\ObjectManager;

class PageManager extends ObjectManager
{
    public function findByRoute($route)
    {
        $page = $this->findBy(array('a.enabled' => true, 'a.route' => $route), array('a.blocks' => 'b'), array('b.position' => 'ASC'))->getQuery()->getResult();

        if (!isset($page[0])) {
            $page = null;
        } else {
            $page = $page[0];
        }

        return $page;
    }
}
