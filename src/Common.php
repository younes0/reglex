<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Common
{   
    // later: ajouter mois
    static public function dateLettres()
    {
        // ex: 24 mai 1938
        return (new RegExpBuilder)->getNew() 
            ->min(1)->max(2)->digits()
            ->then(' ')
            ->anything()
            ->then(' ')
            ->exactly(4)->digits();
    }

    static public function duOuEndDateDu($name = 'date')
    {
        // ex: [du|en date du] 7 novembre 1958  
        return (new RegExpBuilder)->getNew()
            ->anyOf(['en date du', 'du'])
            ->then(' ')
            ->append($this->dateLettres())
            ->asGroup($name);
    }

    static public function oneNumber()
    {
        return (new RegExpBuilder)
            ->getNew()
            ->min(1)
            ->digits();
    }
    
    static public function twoNumbers($separator = '-')
    {   
        // ex: 123-1234
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
