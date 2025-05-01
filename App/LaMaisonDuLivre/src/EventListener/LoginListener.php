<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use App\Repository\EmpruntRepository;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Emprunt;
use App\Entity\Utilisateur;
use App\Entity\Empruntexemplaire;
use App\Entity\Exemplaire;
use Symfony\Component\HttpFoundation\RequestStack;

final class LoginListener
{
    private EmpruntRepository $empruntRepository;
    private RequestStack $requestStack;

    public function __construct(EmpruntRepository $empruntRepository, RequestStack $requestStack)
    {
        $this->empruntRepository = $empruntRepository;
        $this->requestStack = $requestStack;
    }

    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        // Vérifiez si l'utilisateur est authentifié et a des emprunts
        if ($user && method_exists($user, 'getIdutilisateur')) {
            $emprunts = $this->empruntRepository->findBy(['utilisateur' => $user]);

            foreach ($emprunts as $emprunt) {
                $dateRendu = $emprunt->getDateRendu();
                if ($dateRendu) {
                    $interval = $dateRendu->diff(new \DateTime());
                    if ($interval->days <= 3 && $interval->invert === 0) { // Moins de 3 jours avant la date de retour
                        $session = $this->requestStack->getSession();
                        $session->getFlashBag()->add('warning', 'Vous avez un document à rendre dans moins de 3 jours.');
                        break;
                    }
                }
            }
        }
    }
}