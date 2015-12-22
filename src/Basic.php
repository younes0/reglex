<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Basic extends AbstractExtractor
{   
    use HelpersTrait;

    public function loi()
    {
        $regExp = $this->defaultBuilder()
            ->anyOf(['L.', 'LO.', 'loi n°', 'loi organique n°'])
            ->maybe(' ')
            ->append($this->getBuilder()
                ->eitherFind($this->twoNumbers())
                ->orFind($this->oneNumber())
            )
            ->asGroup('numero')
            ->optional($this->getBuilder()
                ->then(' du ')
                ->append($this->getBuilder()->anyOf(Utils::$codesFr))
                ->asGroup('code')
            )
            ->getRegExp();
        
        $results = $regExp->findIn($this->string);

        foreach ($results[0] as $key => $value) {
            $results['organique'][$key] = Str::contains($value, ['loi organique', 'LO.']);
        }

        return $this->reformat($results, ['numero', 'code']);
    }

    public function decret()
    {
        $regExp = $this->defaultBuilder()
            ->then('décret ')
            ->append($this->numero($this->twoNumbers()))
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    public function decretLoi()
    {
        $regExp = $this->defaultBuilder()
            ->then('décret-loi du ')
            ->append($this->dateLettres())
            ->asGroup('date')
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['date']);
    }

    public function ordonnance()
    {
        $regExp = $this->defaultBuilder()
            ->then('ordonnance ')
            ->eitherFind($this->numero($this->twoNumbers()))
            ->orFind($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['numero', 'date']);
    }

    public function avis()
    {
        $regExp = $this->defaultBuilder()
            ->then('avis')
            ->something()
            ->append($this->getBuilder()->anyOf(Utils::$institutions))
            ->asGroup('institution')
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['institution', 'date']);
    }

    public function arrete()
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêté ')
            ->optional($this->getBuilder()
                ->anyOf(['préfectoral', 'ministériel', 'municipal', 'interministériel'])
            )
            ->asGroup('source')
            ->maybe(' ')
            ->optional($this->numero($this->oneNumber())) // ex: n° 1802 
            ->maybe(' ')
            ->append($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['source', 'numero', 'date']);
    }
    
    protected function arretCaEtJugementTribunalFin()
    {
        return $this->getBuilder()
            ->maybe(', ')
            ->optional($this->getBuilder()
                ->then('siégeant en matière ')
                ->something()
                ->asGroup('matiere')
                ->then(',')
            )
            ->maybe(' ')
            ->optional($this->duOuEndDateDu());

        return $this->reformat($regExp->findIn($this->string));
    }

    public function arretCa()
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêt de la cour d\'appel de ')
            ->min(1)->from(Utils::$coursDappel)
            ->asGroup('ville')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['ville', 'date']);
    }

    // later: array liste tribunaux
    public function jugementTribunal()
    {
        $regExp = $this->defaultBuilder()
            ->then('jugement du tribunal de ')
            ->anythingBut(',')
            ->asGroup('tribunal')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['tribunal', 'date']);
    }

    public function arretCourCassation()
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêt de la Cour de cassation ')
            ->optional($this->getBuilder()
                ->then('(chambre ')
                ->something()
                ->asGroup('chambre')
                ->then(') ')
            )
            ->append($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['date']);
    }

    public function arretCourJusticeUe()
    {
        $regExp = $this->defaultBuilder()
            ->then('arrêt de la cour de justice de l\'union européenne')
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->maybe(', ')
            ->append($this->numero($this->getBuilder()->anythingBut('PPU')))
            ->getRegExp();
    
        return $this->reformat($regExp->findIn($this->string));
    }

    public function circulaire()
    {
        $regExp = $this->defaultBuilder()
            ->then('circulaire ')
            ->anyOf(['de', 'du'])
            ->then(' ')
            // ex: ministre de l'intérieur du 26 janvier 1993 relative à sujet
            ->eitherFind($this->getBuilder() // ex: L. 
                ->anythingBut('du ')
                ->asGroup('institution1')
                ->then(' ')
                ->append($this->duOuEndDateDu())
            )
            // ex: ministre de l\'intérieur relative à sujet
            ->orFind($this->getBuilder()
                ->anythingBut('relative ')
                ->asGroup('institution2')
                ->maybe(' ')
            )
            ->then(' relative ')->anyOf(['à', 'au', 'aux'])->then(' ')
            ->anything()
            ->asGroup('sujet')
            ->then(';')
            ->getRegExp();

        $output = $regExp->findIn($this->string);

        for ($i=1; $i <= 2; $i++) { 
            foreach ($output['institution'.$i] as $key => $value) {
                if ( !$value) {
                    unset($output['institution'.$i][$key]);
                }
            }
        }

        $output['institution'] = array_merge(
            array_filter($output['institution1']),
            array_filter($output['institution2'])
        );
        unset($output['institution1'], $output['institution2']);

        return $this->reformat($output, ['institution', 'date']);
    }

    public function directiveUe()
    {
        $regExp = $this->defaultBuilder()
            ->then('directive ')
            ->append($this->twoNumbers('/')->then('/CE'))->asGroup('numero')
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    // later: multiple numéros (ex: eitherFind($this->numeros))
    public function decisionClassiqueCe()
    {
        $regExp = $this->defaultBuilder()
            ->then('décision du Conseil d\'État ')
            ->append($this->numero($this->oneNumber()))
            ->maybe(' ')
            ->optional($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    // later: multiple numéros (ex: eitherFind($this->numeros))
    public function decisionRenvoiCe()
    {
        $regExp = $this->defaultBuilder()
            ->then('Conseil d\'Etat (décision ')
            ->append($this->numero($this->oneNumber()))
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    public function constitution()
    {
        return $this->countStrings(Utils::$constitutions, $this->string);
    }

    public function convention()
    {
        return $this->countStrings(Utils::$conventions, $this->string);
    }

    public function decisionCadreUe()
    {
        $regExp = $this->defaultBuilder()
            ->then('décision-cadre ')
            ->append($this->numero($this->twoNumbers('/')->then('/JAI')))
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    public function decisionCc()
    {
        $string = str_replace(' et autres', null, $this->string);
        $string = str_replace(' à ', '/', $string);

        $regExp = $this->defaultBuilder()
            ->append($this->numero(
                $this->twoNumbers()
                ->anythingBut(' ')
                ->then(' ')
                ->anyOf(Utils::$typeDecisionsConstitutionnelles)
            ))
            ->then(' ')
            ->getRegExp();

        return $this->reformat($regExp->findIn($string));
    }

    public function deliberationCc()
    {
        $regExp = $this->defaultBuilder()
            ->then('délibération du Conseil constitutionnel ')
            ->append($this->duOuEndDateDu())
            ->getRegExp();
            
        return $this->reformat($regExp->findIn($this->string), ['date']);
    }

    public function reglementCeOuUe()
    {
        $regExp = $this->defaultBuilder()
            ->then('règlement (')
            ->append($this->getBuilder()->anyOf(['UE', 'CE']))
            ->asGroup('institution')
            ->then(') ')
            ->append($this->numero($this->twoNumbers('/')))
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string));
    }

    public function reglementCc()
    {
        $regExp = $this->defaultBuilder()
            ->then('règlement ')
            ->append($this->duOuEndDateDu())
            ->anythingBut('constitutionnalité')
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['date']);
    }

    public function decisionOuArretCedh()
    {
        $regExp = $this->defaultBuilder()
            ->anyOf(['arrêt', 'décision'])
            ->then(' de la Cour européenne des droits de l\'homme ')
            ->eitherFind($this->numero($this->twoNumbers('/')))
            ->orFind($this->duOuEndDateDu())
            ->getRegExp();

        return $this->reformat($regExp->findIn($this->string), ['numero', 'date']);
    }
}
