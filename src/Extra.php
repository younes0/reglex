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

    protected function dccVisaOuConsiderant($start, $string)
    {
        $regExp = $this->defaultBuilder()
            ->startOfLine()->then($start)
            ->anything()
            ->then(';')->endOfLine()
            ->getRegExp();
        
        return $regExp->findIn($string);
    }

    public function dccVisa($string)
    {
        $this->dccVisaOuConsiderant('Vu ');
    }

    public function dccConsiderant()
    {
        $this->dccVisaOuConsiderant('Considérant ');
    }

    public function dccOuCommentaireDccPremierParagraphe()
    {
        $regExp = $this->builder->getNew()->ignoreCase()
            ->startOfLine()->then('Le Conseil constitutionnel a été saisi')
            ->anything()
            ->then('.')->endOfLine()
            ->getRegExp();
        
        return $regExp->findIn($string);
    }

    public function dccMembres()
    {
        $sub = après 'où siégeaient ' et avant '“Rendu public”';
        $sub = str_replace(['Président ', 'MM', 'Mme', 'MR', 'Mmes', '. '], ' ', $string);
        $members = explode(',' $sub);
        $members = array_map('trim', $members);
        asort($members);

        return $members;
    }
}
