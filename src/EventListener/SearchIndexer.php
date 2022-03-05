<?php

namespace App\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;


class SearchIndexer
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();


        if (!$entity instanceof Product) {
            return;
        }

        $entityManager = $args->getEntityManager();
// ... do something with the Product
    }
}