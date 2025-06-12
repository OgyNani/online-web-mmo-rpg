<?php

namespace App\EventSubscriber;

use App\Attribute\RouteRole;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class RouteRoleSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (!is_object($controller)) {
            return;
        }

        $method = $event->getRequest()->attributes->get('_route');
        try {
            $reflectionMethod = new \ReflectionMethod($controller, $method);
        } catch (\ReflectionException) {
            return;
        }

        $publicRoutes = ['api_login', 'app_register'];
        if (in_array($method, $publicRoutes)) {
            return;
        }

        if (!$this->security->getUser()) {
            throw new AccessDeniedHttpException('Authentication required.');
        }

        $attributes = $reflectionMethod->getAttributes(RouteRole::class);
        if (empty($attributes)) {
            if (!$this->security->isGranted('ROLE_PLAYER')) {
                throw new AccessDeniedHttpException('Access denied.');
            }
            return;
        }

        $routeRole = $attributes[0]->newInstance();
        if (!$this->security->isGranted($routeRole->role)) {
            throw new AccessDeniedHttpException('Access denied.');
        }
    }
}
