<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Extra
{   
    use CommonTrait;
    
    public function __construct()
    {
        $this->builder = new RegExpBuilder();
    }

    protected function defaultBuilder()
    {
        return $this->builder->getNew()->ignoreCase()->globalMatch();
    }

    protected function dccVisaOuConsiderant(RegExpBuilder $start, $string)
    {
        $regExp = $this->defaultBuilder()
            ->multiLine()
            ->startOfLine()
            ->append($start)
            ->anything()
            ->then(';')
            ->getRegExp();
        
        return $regExp->findIn($string);
    }

    public function dccVisa($string)
    {
        return $this->dccVisaOuConsiderant(
            $this->builder->getNew()->then('Vu '),
            $string
        );
    }

    public function dccConsiderant($string)
    {
        return $this->dccVisaOuConsiderant(
            $this->builder->getNew()->min(1)->digits()->then('. Considérant '),
            $string
        );
    }

    public function dccOuCommentaireDccPremierParagraphe($string)
    {
        $regExp = $this->builder->getNew()->ignoreCase()
            ->startOfLine()->then('Le Conseil constitutionnel a été saisi')
            ->anything()
            ->then('.')->endOfLine()
            ->getRegExp();
        
        return $regExp->findIn($string);
    }

    public function dccMembres($string)
    {
        $regExp = $this->builder->getNew()->ignoreCase()
            ->then('où siégeaient :')
            ->anything()
            ->asGroup('membres')
            ->then('.')
            ->getRegExp();

        $result = $regExp->findIn($string);

        if ( !isset($result['membres'])) {
            return null;
        }

        $string  = $result['membres'];
        $string  = str_replace([' et ', 'Président,', '.'], ' ', $string);
        $membres = explode(',', $string);
        
        $toReplace = array_map(function($value) { 
            return $value.' ';
        }, Utils::$titresCivilite); 

        $membres = array_map(function($value) use ($toReplace) {
            return trim(str_replace($toReplace, '', $value));
        }, $membres);
        
        sort($membres);

        return array_filter($membres);
    }

    public function refDocAuteurs($string)
    {
        $regExp = $this->defaultBuilder()
            ->multiLine()
            ->lineBreak()
            ->startOfLine()
            ->maybe('Voir ')
            ->optional($this->builder->getNew()
                ->anyOf(Utils::$titresCivilite)
                ->maybe('.')
                ->then(' ')
            )
            ->anythingBut(',')
            ->asGroup('auteur')
            ->then(',')
            ->anything()
            ->endOfLine()
            ->getRegExp();

        return $this->reformat($regExp->findIn($string));
    }
}
