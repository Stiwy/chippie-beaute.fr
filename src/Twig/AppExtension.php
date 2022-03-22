<?php

namespace App\Twig;

use App\Entity\ProductSheet;
use App\Entity\SubCategory;
use App\Service\Price;
use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('ksort', [$this, 'ksort']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('column_sub_categories', [$this, 'columnSubCategories']),
            new TwigFunction('price_ttc', [$this, 'priceTTC']),
        ];
    }

    public function columnSubCategories(PersistentCollection $subCategories): array
    {
        $result = [];

        foreach ($subCategories as $subCategory) {
            if ($subCategory->getActive()) $result[$subCategory->getPositionColumn()][$subCategory->getPosition()] = $subCategory;
        }

        ksort($result);
        return $result;
    }

    public function priceTTC(string $price, float $tva): string
    {
        $price = (float) $price / 100;

        return number_format($price * $tva, 2) . ' €';
    }

    public function ksort(array $array): array
    {
        ksort($array);

        return $array;
    }
}