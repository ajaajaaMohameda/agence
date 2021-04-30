<?php

namespace App\EventSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
class UserAgentSubscriber implements EventSubscriberInterface
{
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        if(!$event->isMasterRequest()) {
            return;
        }
    
        // $event->setResponse(new Response('AJAAJAA Mohamed'));
        $request = $event->getRequest();
        $request->attributes->set('_isMac', $this->isMac($request));
         $userAgent = $request->headers->get('User-agent');
   /*     $isMac = stripos($userAgent, 'Mac') !== false; */
        // $request->attributes->set('isMac', $isMac);
        
/*         $request->attributes->set('_controller', function() {
            return new Response('I just took over the controller!');
        }); */
       

        $this->logger->info(sprintf('The User-agent is "%s"', $userAgent));
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    private function isMac(Request $request): bool
    {
        if($request->query->has('mac')) {
            return $request->query->getBoolean('mac');
        }

        $userAgent = $request->headers->get('User-Agent');

        return stripos($userAgent, 'Mac') !== false;
    }
}
