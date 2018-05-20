<?php

namespace App\EventSubscriber;

use App\Entity\Package;
use App\Entity\Tour;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;

class LegacyIdSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @var Package[]
     */
    private $updatedPackages = [];

    /**
     * @var Tour[]
     */
    private $updatedTours = [];

    public function getSubscribedEvents()
    {
        return ['postFlush', 'postPersist'];
    }

    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if ($entity instanceof Package) {
            $this->updatedPackages[] = $entity;
        }
        elseif ($entity instanceof Tour) {
            $this->updatedTours[] = $entity;
        }
    }

    /**
     * @param PostFlushEventArgs $args
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     */
    public function postFlush(PostFlushEventArgs $args)
    {
        $manager = $args->getEntityManager();
        if ($this->updatedPackages) {
            $manager->getConnection()->executeUpdate(
                'update  Tournaments t1 inner JOIN Tournaments t2 on (t1.ParentTextId = t2.TextId) set t1.ParentId=t2.Id WHERE t1.ParentId=0;'
            );
            foreach ($this->updatedPackages as $package) {
                $manager->refresh($package);
            }
            $this->updatedPackages = [];
        }

        if ($this->updatedTours) {
            $manager->getConnection()->executeUpdate(
                'update  Questions q INNER JOIN Tournaments t on (q.ParentTextId = t.TextId) set q.ParentId=t.Id WHERE q.ParentId=0'
            );
            foreach ($this->updatedTours as $tour) {
                $manager->refresh($tour);
            }
        }
    }
}
