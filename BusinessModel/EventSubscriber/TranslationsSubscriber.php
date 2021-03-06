<?php


namespace HabanaTech\BusinessModel\EventSubscriber;

use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use HabanaTech\BusinessModel\ORM\Interfaces\TranslatableInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class TranslationsSubscriber implements EventSubscriberInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * TranslationsSubscriber constructor.
     */
    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->disableExceptionOnInvalidPropertyPath()
                ->getPropertyAccessor();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT       => 'submit',
            FormEvents::PRE_SUBMIT   => 'preSubmit',
            KernelEvents::FINISH_REQUEST => 'end'
        ];
    }


    public function submit(SubmitEvent $event): void
    {
        $entity = $event->getForm()->getParent()->getNormData();
        if ($entity instanceof TranslatableInterface === false) {
            return;
        }

        //delete fielt to not add it later to metadata root
         $event->getForm()->getParent()->remove($event->getForm()->getName());

    }


    public function preSubmit(PreSubmitEvent $event): void
    {
//        dump($event);
        if ($event->getForm()->getParent() !== null) {
            $entity = $event->getForm()->getParent()->getNormData();
            if ($entity instanceof TranslatableInterface === false) {
                return;
            }

            /**
             * @var TranslatableInterface $entity
             */
            $data = $event->getData();

            dump([$event->getForm()->getName() => $data]);
            $translations = $entity->getTranslations();
            $this->propertyAccessor->setValue($translations, '['.$event->getForm()->getName().']', $data);
            $entity->setTranslations($translations);

//            $event->getForm()->getParent()->remove($event->getForm()->getName());
//
//            $entity->getTranslations()->set($event->getForm()->getName(), $data);
//            ($event->getForm()->getName(), json_decode($event->getData(), true));

        }

//        dump($event);
//        exit();
    }

public function end(FinishRequestEvent $event): void
{
//     exit();
}
}

