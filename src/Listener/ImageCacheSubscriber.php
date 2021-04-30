<?php
namespace App\Listener;

use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    /**
     * Undocumented variable
     *
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * Undocumented variable
     *
     * @var UploaderHelper
     */
    private $uploadHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploadHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $property = $args->getEntity();
        if(!$property instanceof Property) {
            return;
        }

        $this->cacheManager->remove($this->uploadHelper->asset($property, 'imageFile'));

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $property = $args->getEntity();
        if(!$property instanceof Property) {
            return;
        }

        if($property->getImageFile() instanceof UploadedFile) {

            $this->cacheManager->remove($this->uploadHelper->asset($property, 'imageFile'));
        }

      
    }
}