<?php
namespace App\EventListener;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Usuarios;
use App\Service\FileUploader;

class GenericUploadListener
{
    private $uploader;
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }
    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Usuarios) {
            return;
        }
        $file = $entity->getAvatar();
        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setAvatar($fileName);
        }
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Usuarios) {
            return;
        }
        if ($fileName = $entity->getAvatar()) {
            $entity->setAvatar(
                new File(
                    $this->uploader->getTargetDir().'/'.$fileName
                )
            );
        }
    }
}