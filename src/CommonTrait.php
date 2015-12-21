<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

trait CommonTrait
{   
    protected function getBuilder()
    {
        return (new RegExpBuilder())->getNew()->pregMatchFlags(256);
    }

    protected function defaultBuilder()
    {
        return $this->getBuilder()
            ->ignoreCase()
            ->globalMatch()
            ->pregMatchFlags(256);
    }

    protected function reformat($array, $idKeys = ['numero'])
    {
        $output = [];

        foreach ($array as $originalKey => $values) {

            if (is_int($originalKey) and $originalKey !== 0) continue;

            foreach ($values as $parentKey => $value) {
                if ($value === '') $value = null; // convert to null

                if ($originalKey === 0) {
                    $output[$parentKey]['raw']       = $value[0];
                    $output[$parentKey]['raw_start'] = $value[1];
                    $output[$parentKey]['raw_end']   = $value[1] + strlen($value[0]);
      
                } else {
                    $output[$parentKey][$originalKey] = $value[0];
                }
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
    
    protected function countStrings($array, $text)
    {
        $found = [];

        foreach ($array as $id => $strings) {
            foreach ($strings as $string) {

                $start = 0;

                while (($pos = stripos($text, $string, $start)) !== false) {
 
                    $start = $pos + strlen($string);

                    $found[] = [
                        'id'        => $id,
                        'raw'       => $string,
                        'raw_start' => $pos,
                        'raw_end'   => $start,
                    ];
                }
            }
        }

        return $found;
    }
    
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
}
