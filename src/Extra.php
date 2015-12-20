<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;

class Extra
{   
    use CommonTrait;
    
    protected function dccVisaOuConsiderant(RegExpBuilder $start, $string)
    {
        $regExp = $this->defaultBuilder()
            ->multiLine()
            ->append($this->defaultBuilder()
                ->startOfLine()
                ->append($start)
                ->anything()
                ->then(';')
            )
            ->asGroup('raw')
            ->endOfLine()
            ->getRegExp();

        return $this->reformat($regExp->findIn($string));
    }

    public function dccVisa($string)
    {
        return $this->dccVisaOuConsiderant(
            $this->getBuilder()->then('Vu '),
            $string
        );
    }

    public function dccConsiderant($string)
    {
        return $this->dccVisaOuConsiderant(
            $this->getBuilder()->min(1)->digits()->then('. Considérant '),
            $string
        );
    }

    public function dccOuCommentaireDccPremierParagraphe($string)
    {
        $regExp = $this->defaultBuilder()
            ->append($this->defaultBuilder()
                ->startOfLine()
                ->then('Le Conseil constitutionnel a été saisi')
                ->anything()
                ->then('.')
            )
            ->asGroup('raw')
            ->endOfLine()
            ->getRegExp();

        return $this->reformat($regExp->findIn($string));
    }

    public function dccMembres($string)
    {
        $regExp = $this->getBuilder()->ignoreCase()
            ->then('où siégeaient :')
            ->anything()
            ->asGroup('membres')
            ->then('.')
            ->getRegExp();

        $result = $regExp->findIn($string);

        if ( !isset($result['membres'])) {
            return null;
        }

        $string  = $result['membres'][0];
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
            ->optional($this->getBuilder()
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

        return $this->reformat($regExp->findIn($string), ['auteur']);
    }
}
