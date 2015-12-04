<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Common
{   
    // later: ajouter mois
    // ex: 24 mai 1938
    static public function dateLettres()
    {
        return (new RegExpBuilder)->getNew() 
            ->min(1)->max(2)->digits()
            ->then(' ')
            ->anyOf(Utils::$mois)
            ->then(' ')
            ->exactly(4)->digits();
    }

    // ex: [du|en date du] 7 novembre 1958  
    static public function duOuEndDateDu($name = 'date')
    {
        return (new RegExpBuilder)->getNew()
            ->anyOf(['en date du', 'du'])
            ->then(' ')
            ->append(static::dateLettres())
            ->asGroup($name);
    }

    static public function oneNumber()
    {
        return (new RegExpBuilder)
            ->getNew()
            ->min(1)
            ->digits();
    }
    
    // ex: 123-1234
    static public function twoNumbers($separator = '-')
    {   
        return (new RegExpBuilder)->getNew()
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
}
