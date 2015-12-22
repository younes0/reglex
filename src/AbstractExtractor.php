<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

abstract class AbstractExtractor
{   
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    protected function getBuilder()
    {
        return (new RegExpBuilder())->getNew();
    }

    protected function defaultBuilder()
    {
        return $this->getBuilder()
            ->multiLine()
            ->ignoreCase()
            ->globalMatch();
    }

    protected function reformat($array, $idKeys = ['numero'])
    {
        $output = [];

        foreach ($array as $originalKey => $values) {

            if (is_int($originalKey) and $originalKey !== 0) continue;

            foreach ($values as $parentKey => $value) {
                if ($value === '') $value = null; // convert to null

                if ($originalKey === 0) {
                    $output[$parentKey]['raw'] = $value;
      
                } else {
                    $output[$parentKey][$originalKey] = $value;
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

            $output[$parentKey]['id']   = trim($id);
            $output[$parentKey]['type'] = $this->getType();
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
                        'id'   => $id,
                        'raw'  => $string,
                        'type' => $this->getType(),
                    ];
                }
            }
        }

        return $found;
    }
    
    private function getType()
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'];
    }
}
