<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class IsMacArgumentValueResolver implements ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument)
    {
       //  return $argument->getName() === 'isMac';
       return $argument->getName() === 'isMac' && $request->attributes->has('_isMac');
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
       // $userAgent = $request->headers->get('User-agent');
       //  yield stripos($userAgent, 'Mac') !== false;

       yield $request->attributes->get('_isMac');
    }
}