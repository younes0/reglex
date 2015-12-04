<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Extra
{   
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
            ->then('où siégeaient ')
            ->anything()
            ->asGroup('membres')
            ->then('Rendu public')
            ->getRegExp();

        ldd($regExp->findIn($string));

        // $sub = après 'où siégeaient ' et avant '“Rendu public”';
        // $sub = str_replace(['Président ', 'MM', 'Mme', 'MR', 'Mmes', '. '], ' ', $string);
        // $members = explode(',' $sub);
        // $members = array_map('trim', $members);
        // asort($members);

        // return $members;
    }
}
