<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

trait CommonTrait
{   
    // later: ajouter mois
    // ex: 24 mai 1938
    protected function dateLettres()
    {
        return (new RegExpBuilder)
            ->min(1)->max(2)->digits()
            ->then(' ')
            ->anyOf(Utils::$mois)
            ->then(' ')
            ->exactly(4)->digits();
    }

    // ex: [du|en date du] 7 novembre 1958  
    protected function duOuEndDateDu($name = 'date')
    {
        return (new RegExpBuilder)
            ->anyOf(['en date du', 'du'])
            ->then(' ')
            ->append(static::dateLettres())
            ->asGroup($name);
    }

    protected function oneNumber()
    {
        return (new RegExpBuilder)->min(1)->digits();
    }
    
    // ex: 123-1234
    protected function twoNumbers($separator = '-')
    {   
        return (new RegExpBuilder)
            ->min(0)->digits()
            ->then($separator)
            ->min(0)->digits();
    }

    protected function numero(RegExpBuilder $regExp, $name = 'numero')
    {  
        return (new RegExpBuilder)->getNew()
            ->then('n°')
            ->maybe(' ')
            ->append($regExp)
            ->asGroup($name);
    }

    protected function countStrings($array, $string)
    {
        $found = [];

        foreach ($array as $key => $values) {
            $found[$key] = 0;

            foreach ($values as $value) {
                if ($count = substr_count($string, $value)) {
                    $found[$key]+= $count;
                }
            }
        }

        return $found;
    }
}
