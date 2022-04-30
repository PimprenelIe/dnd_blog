<?php


namespace App\Service;


use App\Entity\Visite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StatsVisites
{
    private $_session;
    private $entityManager;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager
    )
    {
        $this->_session = $session;
        $this->entityManager = $entityManager;
    }

    public function addVisite(string $link, $entity = null): void
    {

        if (empty($link)
            || preg_match('/^\/(_(profiler|wdt)|css|images|js|admin|media|upload)/', $link)
        ) {
            return;
        }

        // On récupère les liens déjà visités en session du jour.
        $visitedDate = $this->_session->get('visitedDate');
        $visitedLinks = $this->_session->get('visitedLinks');

        $today = new \DateTime();
        if (!$visitedDate || $visitedDate->format('Y-m-d') !== $today->format('Y-m-d')) {
            $this->_session->set('visitedDate', $today);
            $visitedLinks = [];
        }

        if (!in_array($link, $visitedLinks)) {

            $visitedLinks[] = $link;
            $this->_session->set('visitedLinks', $visitedLinks);

            $visite = (new Visite())
                ->setLink($link)
                ->setDate($today);
            $this->entityManager->persist($visite);

            if ($entity && method_exists($entity, 'setVisit')) {
                $entity->setVisit($entity->getVisit() + 1);
            }

            try {
                $this->entityManager->flush();
            } catch (\Throwable $e) {
                throw $e;
            }

        }

//            $this->_session->set('lastIp', $ip);
//        }

    }

}