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

    protected function countStrings($array, $text)
    {
        $found = [];

        foreach ($array as $id => $strings) {
            foreach ($strings as $string) {
                
                $count = $this->substriCount($text, $string);

                for ($i=0; $i < $count; $i++) { 
                    $found[] = [
                        'id'  => $id,
                        'raw' => $string,
                    ];
                }
            }
        }

        return $found;
    }

    protected function substriCount($haystack, $needle)
    {
        return substr_count(strtoupper($haystack), strtoupper($needle));
    }

    protected function reformat($array, $idKeys = ['numero'])
    {
        $output = [];

        foreach ($array as $originalKey => $values) {
            if (is_int($originalKey) and $originalKey !== 0) continue;

            foreach ($values as $parentKey => $value) {
                
                if ($value === '') $value = null; // convert to null

                $key = ($originalKey === 0) ? 'raw' : $originalKey;
                $output[$parentKey][$key] = $value;
            }
        }

        // add id keys
        foreach ($output as $parentKey => $value) {
            $id = null;

            foreach ($idKeys as $key) {
                if (isset($value[$key])) {
                    $id.= $value[$key].' '; 
                }   
            }

            $output[$parentKey]['id'] = trim($id);
        }

        return $output;
    }
}
