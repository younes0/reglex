<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Common
{   
    // later: ajouter mois
    // ex: 24 mai 1938
    static public function dateLettres()
    {
        return (new RegExpBuilder)
            ->min(1)->max(2)->digits()
            ->then(' ')
            ->anyOf(Utils::$mois)
            ->then(' ')
            ->exactly(4)->digits();
    }

    // ex: [du|en date du] 7 novembre 1958  
    static public function duOuEndDateDu($name = 'date')
    {
        return (new RegExpBuilder)
            ->anyOf(['en date du', 'du'])
            ->then(' ')
            ->append(static::dateLettres())
            ->asGroup($name);
    }

    static public function oneNumber()
    {
        return (new RegExpBuilder)->min(1)->digits();
    }
    
    // ex: 123-1234
    static public function twoNumbers($separator = '-')
    {   
        return (new RegExpBuilder)
            ->min(1)->digits()
            ->then($separator)
            ->min(1)->digits();
    }

    static public function numero(RegExpBuilder $regExp, $name = 'numero')
    {  
        return (new RegExpBuilder)->getNew()
            ->then('n°')
            ->maybe(' ')
            ->append($regExp)
            ->asGroup($name);
    }

    static public function countStrings($array, $string)
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
