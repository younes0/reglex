<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Base
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

    public function loi($string)
    {
        $regExp = $this->defaultBuilder()
            ->eitherFind($this->builder->getNew() // ex: L. 
                ->anyOf(['L.', 'LO.'])
            )
            ->orFind($this->builder->getNew() // ex: loi organique du n°
                ->anyOf(['loi', 'loi organique'])
                ->something()
                ->then('n°')
            )
            ->maybe(' ')
            ->append($this->twoNumbers())
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
        $regExp = $this->defaultBuilder()
            ->then('décret ')
            ->append($this->numero($this->twoNumbers()))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decretLoi($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('décret-loi du ')
            ->append($this->dateLettres())
            ->asGroup('date')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function ordonnance($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('ordonnance ')
            ->eitherFind($this->numero($this->twoNumbers()))
            ->orFind($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function avis($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('avis')
            ->something()
            ->append($this->builder->anyOf(Utils::$institutions))
            ->asGroup('institution')
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arrete($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêté ')
            ->optional($this->builder->getNew()
                ->anyOf(['préfectoral', 'ministériel', 'municipal', 'interministériel'])
            )
            ->asGroup('type')
            ->maybe(' ')
            ->optional($this->numero($this->oneNumber())) // ex: n° 1802 
            ->maybe(' ')
            ->append($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }
    
    protected function arretCaEtJugementTribunalFin()
    {
        return $this->builder->getNew()
            ->maybe(', ')
            ->optional($this->builder->getNew()
                ->then('siégeant en matière ')
                ->something()
                ->asGroup('matiere')
                ->then(',')
            )
            ->maybe(' ')
            ->optional($this->duOuEndDateDu());

        return $regExp->findIn($string);
    }

    public function arretCa($string)
    {
        $regExp = $this->defaultBuilder()
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
        $regExp = $this->defaultBuilder()
            ->then('jugement du tribunal de ')
            ->anythingBut(',')
            ->asGroup('tribunal')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arretCourCassation($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêt de la Cour de cassation ')
            ->optional($this->builder->getNew()
                ->then('(chambre ')
                ->something()
                ->asGroup('chambre')
                ->then(') ')
            )
            ->append($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function arretCourJusticeUe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêt de la cour de justice de l\'union européenne')
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->maybe(', ')
            ->append($this->numero($this->builder->getNew()->anythingBut('PPU')))
            ->getRegExp();
    
        return $regExp->findIn($string);
    }

    public function circulaire($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('circulaire ')
            ->anyOf(['de', 'du'])
            ->then(' ')
            // ex: ministre de l'intérieur du 26 janvier 1993 relative à sujet
            ->eitherFind($this->builder->getNew() // ex: L. 
                ->anythingBut('du ')
                ->asGroup('institution1')
                ->then(' ')
                ->append($this->duOuEndDateDu())
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

    public function directiveUe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('directive ')
            ->append($this->twoNumbers('/')->then('/CE'))->asGroup('numero')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    // later: multiple numéros (ex: eitherFind($this->numeros))
    public function decisionClassiqueCe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('décision du Conseil d\'État ')
            ->append($this->numero($this->oneNumber()))
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    // later: multiple numéros (ex: eitherFind($this->numeros))
    public function decisionRenvoiCe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('Conseil d\'Etat (décision ')
            ->append($this->numero($this->oneNumber()))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function constitution($string)
    {
        return $this->countStrings(Utils::$constitutions, $string);
    }

    public function convention($string)
    {
        return $this->countStrings(Utils::$conventions, $string);
    }

    public function decisionCadreUe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('décision-cadre ')
            ->append($this->numero($this->twoNumbers('/')->then('/JAI')))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decisionCc($string)
    {
        $string = str_replace(' et autres', null, $string);
        $string = str_replace(' à ', '/', $string);

        $regExp = $this->defaultBuilder()
            ->append($this->numero(
                $this->twoNumbers()
                ->anythingBut(' ')
                ->then(' ')
                ->anyOf(Utils::$typeDecisionsConstitutionnelles)
            ))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function deliberationCc($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('délibération du Conseil constitutionnel ')
            ->append($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function reglementCeOuUe($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('règlement (')
            ->append($this->builder->getNew()->anyOf(['UE', 'CE']))
            ->asGroup('institution')
            ->then(') ')
            ->append($this->numero($this->twoNumbers('/')))
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function reglementCc($string)
    {
        $regExp = $this->defaultBuilder()
            ->then('règlement ')
            ->append($this->duOuEndDateDu())
            ->anythingBut('constitutionnalité')
            ->getRegExp();

        return $regExp->findIn($string);
    }

    public function decisionOuArretCedh($string)
    {
        $regExp = $this->defaultBuilder()
            ->anyOf(['arrêt', 'décision'])
            ->then(' de la Cour européenne des droits de l\'homme ')
            ->eitherFind($this->numero($this->twoNumbers('/')))
            ->orFind($this->duOuEndDateDu())
            ->getRegExp();

        return $regExp->findIn($string);
    }
}
