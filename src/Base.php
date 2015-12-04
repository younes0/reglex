<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Base
{   
    public function __construct()
    {
        $this->builder = new RegExpBuilder();
    }

    public function loi($string)
    {
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->eitherFind($this->builder->getNew() // ex: L. 
                ->anyOf(['L.', 'LO.'])
            )
            ->orFind($this->builder->getNew() // ex: loi organique du n°
                ->anyOf(['loi', 'loi organique'])
                ->something()
                ->then('n°')
            )
            ->maybe(' ')
            ->append(Common::twoNumbers())
            ->asGroup('numero')
            ->optional($this->builder->getNew()
                ->then(' du ')
                ->append($this->builder->getNew()->anyOf(Utils::$codesFr))
                ->asGroup('code')
            )
            ->getRegExp();
        
        $array = $regExp->findIn($string);

        foreach ($array[0] as $key => $value) {
            $array['organique'][$key] = Str::contains($value, ['loi organique', 'LO.']);
        }

        return $array;
    }

    public function decret($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('décret ')
            ->append(Common::numero(Common::twoNumbers()))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decretLoi($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('décret-loi du ')
            ->append(Common::dateLettres())
            ->asGroup('date')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function ordonnance($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('ordonnance ')
            ->eitherFind(Common::numero(Common::twoNumbers()))
            ->orFind(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function avis($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('avis ')
            ->anyOf(['de', 'du'])->then(' ')->anyOf(['l\'', 'le ', 'la '])
            ->something()->asGroup('institution')->reluctantly()
            ->maybe(' ')
            ->optional(Common::duOuEndDateDu())
            ->maybe(';')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arrete($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêté ')
            ->optional($this->builder->getNew()
                ->anyOf(['préfectoral', 'ministériel', 'municipal', 'interministériel'])
            )
            ->asGroup('type')
            ->maybe(' ')
            ->optional(Common::numero(Common::oneNumber())) // ex: n° 1802 
            ->maybe(' ')
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }
    
    protected function arretCaEtJugementTribunalFin()
    {
        $this->builder = new RegExpBuilder;

        return $this->builder
            ->maybe(', ')
            ->optional($this->builder->getNew()
                ->then('siégeant en matière ')
                ->something()
                ->asGroup('matiere')
                ->then(',')
            )
            ->maybe(' ')
            ->optional(Common::duOuEndDateDu());
    }

    public function arretCa($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la cour d\'appel de ')
            ->min(1)->from(Utils::$coursDappel)
            ->asGroup('ville')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    // later: array liste tribunaux
    public function jugementTribunal($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('jugement du tribunal de ')
            ->anythingBut(',')
            ->asGroup('tribunal')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arretCourCassation($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la Cour de cassation ')
            ->optional($this->builder->getNew()
                ->then('(chambre ')
                ->something()
                ->asGroup('chambre')
                ->then(') ')
            )
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arretCourJusticeUe($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la cour de justice de l\'union européenne')
            ->maybe(' ')
            ->optional(Common::duOuEndDateDu())
            ->maybe(', ')
            ->append(Common::numero($this->builder->getNew()->anythingBut('PPU')))
            ->getRegExp();
    
        return $regExp->findIn($string);
    }

    public function circulaire($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('circulaire ')
            ->anyOf(['de', 'du'])
            ->then(' ')
            // ex: ministre de l'intérieur du 26 janvier 1993 relative à sujet
            ->eitherFind($this->builder->getNew() // ex: L. 
                ->anythingBut('du ')
                ->asGroup('institution1')
                ->then(' ')
                ->append(Common::duOuEndDateDu())
            )
            // ex: ministre de l\'intérieur relative à sujet
            ->orFind($this->builder->getNew()
                ->anythingBut('relative ')
                ->asGroup('institution2')
                ->maybe(' ')
            )
            ->then(' relative ')->anyOf(['à', 'au', 'aux'])->then(' ')
            ->anything()
            ->asGroup('sujet')
            ->then(';')
            ->getRegExp();

        $output = $regExp->findIn($string);

        $output['institution'] = array_merge(
            array_filter($output['institution1']),
            array_filter($output['institution2'])
        );
        unset($output['institution1'], $output['institution2']);

        return $output;
    }

    public function convention($string)
    {
        $this->builder = new RegExpBuilder();

        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('convention ')->anyOf(['de', 'des', 'du'])->then(' ')
            ->something()
            ->asGroup('nom')
            ->maybe(' ')
        // ->anyOf(['relative', ',', ';', '.'])
        // ->anyOf(['relative', ','])
        // ->something()
        // ->asGroup('sujet')
        // ->anyOf([';', '.'])
            ->getRegExp();

        return $regExp->findIn($string);


        $output = $regExp->findIn($string);

        // TODO: multi level
        // scinder nom en dates
        if (isset($output['nom'])) {
            $regExp = $this->builder->getNew()->startOfInput()->ignoreCase()
                ->anything()
                ->asGroup('nom')
                ->append(Common::duOuEndDateDu())
                ->getRegExp();

            $output = $regExp->findIn(trim($output['nom']));
        }

        ldd($output);
    }

    public function directiveUe($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('directive ')
            ->append(Common::twoNumbers('/')->then('/CE'))->asGroup('numero')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    // later: multiple numéros (ex: eitherFind(Common::numeros))
    public function decisionClassiqueCe($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('décision du Conseil d\'État ')
            ->append(Common::numero(Common::oneNumber()))
            ->maybe(' ')
            ->optional(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    // later: multiple numéros (ex: eitherFind(Common::numeros))
    public function decisionRenvoiCe($string)
    {
        $this->builder = new RegExpBuilder();
     
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('Conseil d\'Etat (décision ')
            ->append(Common::numero(Common::oneNumber()))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function constitution($string)
    {
        return $this->findStringsIn(Utils::$constitutions, $string);
    }

    protected function findStringsIn($array, $string)
    {
        $found = [];

        foreach ($array as $key => $values) {
            $found[$key] = 0;

            if ($count = substr_count($string, $key)) {
                $found[$key] = $count;
            }

            foreach ($values as $value) {
                if ($count = substr_count($string, $value)) {
                    $found[$key]+= $count;
                }
            }
        }

        return $found;
    }

    public function decisionCadreUe($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('décision-cadre ')
            ->append(Common::numero(Common::twoNumbers('/')->then('/JAI')))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decisionCc($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->append(Common::numero(
                Common::twoNumbers()
                ->then(' ')
                ->anyOf(Utils::$typeDecisionsConstitutionnelles)
            ))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function deliberationCc($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('délibération du Conseil constitutionnel ')
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function reglementCeOuUe($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('règlement (')
            ->append($this->builder->getNew()->anyOf(['UE', 'CE']))
            ->asGroup('institution')
            ->then(') ')
            ->append(Common::numero(Common::twoNumbers('/')))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function reglementCc($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->then('règlement ')
            ->append(Common::duOuEndDateDu())
            ->anythingBut('constitutionnalité')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decisionOuArretCedh($string)
    {
        $this->builder = new RegExpBuilder();
        
        $regExp = $this->builder->getNew()->ignoreCase()->globalMatch()
            ->anyOf(['arrêt', 'décision'])
            ->then(' de la Cour européenne des droits de l\'homme ')
            ->eitherFind(Common::numero(Common::twoNumbers('/')))
            ->orFind(Common::duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }
}
