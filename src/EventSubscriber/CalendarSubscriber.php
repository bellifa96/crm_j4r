<?php

namespace App\EventSubscriber;

use App\Repository\Affaire\EvenementRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $evenementRepository;
    private $router;

    public function __construct(
        EvenementRepository $evenementRepository,
        UrlGeneratorInterface $router
    ) {
        $this->evenementRepository = $evenementRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        dd($calendar);
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change evenement.beginAt by your start date property
        $evenements = $this->evenementRepository
            ->createQueryBuilder('evenement')
            ->where('evenement.beginAt BETWEEN :start and :end OR evenement.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($evenements as $evenement) {
            // this create the events with your data (here evenement data) to fill calendar
            $evenementEvent = new Event(
                $evenement->getTitle(),
                $evenement->getBeginAt(),
                $evenement->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $evenementEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $evenementEvent->addOption(
                'url',
                $this->router->generate('evenement_show', [
                    'id' => $evenement->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($evenementEvent);
        }
    }
}