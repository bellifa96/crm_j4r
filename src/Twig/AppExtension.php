<?php

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Twig\AppRuntime;


class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('recursive', [$this, 'devisHtml']),
        ];
    }

    public function devisHtml($object=[]): array
    {
        return $object;
    }
}