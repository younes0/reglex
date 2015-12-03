<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Base
{   
    static protected $coursDappel = [ 'Agen', 'Aix-en-Provence', 'Amiens', 'Angers', 'Basse-Terre', 'Bastia', 'Besançon', 'Bordeaux', 'Bourges', 'Caen', 'Cayenne', 'Chambéry', 'Colmar', 'Dijon', 'Douai', 'Fort-de-France', 'Grenoble', 'Limoges', 'Lyon', 'Metz', 'Montpellier', 'Nancy', 'Nouméa', 'Nîmes', 'Orléans', 'Papeete', 'Paris', 'Pau', 'Poitiers', 'Reims', 'Rennes', 'Riom', 'Rouen', 'Saint-Denis', 'Saint-Denis-de-la-Réunion', 'Toulouse', 'Versailles' ];

    static protected $codesFr = [
        'code civil', 'code de commerce', 'code de construction des appareils à pression non soumis à la flamme', 'code de déontologie', 'code de déontologie de la police nationale', 'code de déontologie des activités privées de sécurité', 'code de déontologie des avocats', 'code de déontologie des psychologues', 'code de déontologie médicale', 'code de justice administrative', 'code de l\'action sociale et des familles', 'code de l\'artisanat', 'code de l\'aviation civile', 'code de l\'entrée et du séjour des étrangers et du droit d\'asile', 'code de l\'environnement', 'code de l\'expropriation pour cause d\'utilité publique', 'code de l\'organisation judiciaire', 'code de l\'urbanisme', 'code de l\'éducation', 'code de l\'énergie', 'code de la consommation', 'code de la construction et de l\'habitation', 'code de la défense', 'code de la famille et de l\'aide sociale', 'code de la mutualité', 'code de la propriété intellectuelle', 'code de la recherche', 'code de la route en france', 'code de la santé publique', 'code de la sécurité intérieure', 'code de la sécurité sociale', 'code de la voirie routière', 'code de procédure civile', 'code de procédure pénale', 'code des assurances', 'code des douanes', 'code des juridictions financières', 'code des marchés publics', 'code des postes et des communications électroniques', 'code des procédures civiles d\'exécution', 'code des transports', 'code du cinéma et de l\'image animée', 'code du patrimoine', 'code du sport', 'code du tourisme', 'code du travail', 'code forestier', 'code général de la propriété des personnes publiques', 'code général des collectivités territoriales', 'code général des impôts', 'code monétaire et financier', 'code pénal', 'code rural et de la pêche maritime', 'code électoral', 'codes napoléoniens', 'dossier de consultation des entreprises', 'droit des marchés publics en france', 'droit minier', 'livre des procédures fiscales', 
    ];

    static protected $typeDecisionsConstitutionnelles = [ 'QPC', 'DC', 'LP', 'L', 'FNR', 'LOM', 'AN', 'SEN', 'PDR', 'REF', 'ELEC', 'D', 'I', 'ART16', 'ORGA', 'AUTR' ];

    public function loi($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->eitherFind($builder->getNew() // ex: L. 
                ->anyOf(['L.', 'LO.'])
            )
            ->orFind($builder->getNew() // ex: loi organique du n°
                ->anyOf(['loi', 'loi organique'])
                ->something()
                ->then('n°')
            )
            ->maybe(' ')
            ->append(Common::twoNumbers())
            ->asGroup('numero')
            ->optional($builder->getNew()
                ->then(' du ')
                ->append($builder->getNew()->anyOf(static::$codesFr))
                ->asGroup('code')
            )
            ->getRegExp();
 
        return $regExp->findIn($string);
        $output = $regExp->findIn($string);
        $output['organique'] = Str::contains($string, ['loi organique', 'LO.']);
    }

    public function decret($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('décret ')
            ->append(Common::numero(Common::twoNumbers()))
            ->getRegExp();

        // tests
        $string = 'le décret n° 86-451';
        $string = 'décret n° 2006-1231';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function decretLoi($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('décret-loi du ')
            ->append(Common::dateLettres())
            ->asGroup('date')
            ->getRegExp();

        // tests
        $string = 'décret-loi du 24 mai 1938';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function ordonnanCe($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('ordonnance ')
            ->eitherFind(Common::numero(Common::twoNumbers()))
            ->orFind(Common::duOuEndDateDu())
            ->getRegExp();

        // tests
        $string = 'ordonnance n° 58-1067';
        $string = 'ordonnance du 7 novembre 1958';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function avis($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('avis ')
            ->anyOf(['de', 'du'])->then(' ')->anyOf(['l\'', 'le ', 'la '])
            ->something()->asGroup('institution')->reluctantly()
            ->maybe(' ')
            ->optional(Common::duOuEndDateDu())
            ->getRegExp();

        // tests
        $string = 'l\'avis de l\'Assemblée territoriale de la Polynésie française en date du 25 novembre 1993';
        $string = 'l\'avis de la Commission nationale de l\'informatique et des libertés';
   
        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function arrete($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêté ')
            ->optional($builder->getNew()
                ->anyOf(['préfectoral', 'ministériel', 'municipal', 'interministériel'])
            )
            ->asGroup('type')
            ->maybe(' ')
            ->optional(Common::numero(Common::oneNumber())) // ex: n° 1802 
            ->maybe(' ')
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        $string = 'l\'arrêté du 12 février 2010';
        $string = 'l\'arrêté interministériel n° 1802 du 29 juin 1979';

        $output = $regExp->findIn($string);
        ldd($output);
    }
    
    protected function arretCaEtJugementTribunalFin($string)
    {
        $builder = new RegExpBuilder;

        return $builder
            ->maybe(', ')
            ->optional($builder->getNew()
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
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la cour d\'appel de ')
            ->min(1)->from(static::$coursDappel)
            ->asGroup('ville')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        $string = 'l\'arrêt de la cour d\'appel de Lyon';
        $string = 'l\'arrêt de la cour d\'appel de Lyon, en date du 14 décembre 1994';
        $string = 'l\'arrêt de la cour d\'appel de Saint-Denis-de-la-Réunion, siégeant en matière civile, en date du 14 décembre 1994';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function jugementTribunal($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('jugement du tribunal de ')
            ->anythingBut(',')
            ->asGroup('tribunal')
            ->append($this->arretCaEtJugementTribunalFin())
            ->getRegExp();

        $string = 'le jugement du tribunal de grande instance d\'Argentan';
        $string = 'le jugement du tribunal de commerce, en date du 7 novembre 1995';
        $string = 'le jugement du tribunal de grande instance d\'Argentan, siégeant en matière correctionnelle, en date du 7 novembre 1995';

        $output = $regExp->findIn($string);
        ldd($output);   
    }

    public function arretCourCassation($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la Cour de cassation ')
            ->optional($builder->getNew()
                ->then('(chambre ')
                ->something()
                ->asGroup('chambre')
                ->then(') ')
            )
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        $string = 'Vu l\'arrêt de la Cour de cassation en date du 7 décembre 1995';
        $string = 'Vu l\'arrêt de la Cour de cassation (chambre criminelle) du 30 novembre 2005';

        $output = $regExp->findIn($string);
        ldd($output);   
    }

    public function arretCourJusticeUe($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('arrêt de la cour de justice de l\'union européenne ')
            ->append(Common::duOuEndDateDu())
            ->then(', n° ')
            ->append($builder->getNew()
                ->anythingBut('PPU')
                ->anyOf(['PPU']) // TODO:revoir
            )
            ->asGroup('numero')
            // ->then(' ;')
            ->getRegExp();

        $string = 'l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° C-168/13 PPU ;';
        $string = 'l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° T-175/04 PPU ;';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function circulaire($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('circulaire ')
            ->anyOf(['de', 'du'])
            ->then(' ')
            // ex: ministre de l'intérieur du 26 janvier 1993 relative à sujet
            ->eitherFind($builder->getNew() // ex: L. 
                ->anythingBut(' du ')
                ->asGroup('organisme1')
                ->then(' ')
                ->append(Common::duOuEndDateDu())
            )
            // ex: ministre de l\'intérieur relative à sujet
            ->orFind($builder->getNew()
                ->anythingBut(' relative ')
                ->asGroup('organisme2')
                ->maybe(' ')
            )
            ->then(' relative ')->anyOf(['à', 'au', 'aux'])->then(' ')
            ->anything()
            ->asGroup('sujet')
            ->then(';')
            ->getRegExp();

        $string = 'la circulaire du ministre de l\'intérieur et de la sécurité publique du 26 janvier 1993 relative à l\'organisation des élections législatives des 21 et 28 mars 1993;';
        $string = 'la circulaire du ministre de l\'intérieur relative à l\'envoi des formulaires de présentation d\'un candidat à l\'élection présidentielle;';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function convention($string)
    {
        $builder = new RegExpBuilder();

        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
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

        $string = 'la Convention de Genève du 28 juillet 1951 relative au statut des réfugiés et le protocole signé à New York le 31 janvier 1967 ;';
        // $string = 'la Convention de sauvegarde des droits de l\'homme et des libertés fondamentales ;';
        // $string = 'La Convention de sauvegarde des droits de l\'homme et des libertés fondamentales, signée à Rome le 4 novembre 1950 ;';

        $output = $regExp->findIn($string);

        // TODO: multi level
        // scinder nom en dates
        if (isset($output['nom'])) {
            $regExp = $builder->getNew()->startOfInput()->ignoreCase()
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
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('directive ')
            ->append(Common::twoNumbers('/')->then('/CE'))->asGroup('numero')
            ->getRegExp();

        $string = 'la directive 2003/54/CE';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    // later: multiple numéros (ex: eitherFind(Common::numeros))
    public function decisionClassiqueCe($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('décision du Conseil d\'État ')
            ->append(Common::numero(Common::oneNumber()))
            ->getRegExp();

        $string = 'la décision du Conseil d\'État n° 222160 du 30 juin 2003';
        // $string = 'la décision du Conseil d\'État nos 265582 et 273093 du 13 mars 2006 ;';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    // later: multiple numéros (ex: eitherFind(Common::numeros))
    public function decisionRenvoiCe($string)
    {
        $builder = new RegExpBuilder();
     
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('Conseil d\'Etat (décision ')
            ->append(Common::numero(Common::oneNumber()))
            ->getRegExp();

        $string = 'par le Conseil d\'Etat (décision n° 387472 du même jour) ;';
        // $string = 'par le Conseil d\'Etat Conseil d\'État (décision nos 380743, 380744 et 380745 du 23 juillet 2014) ;';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function constitution($string)
    {
        $values = [
            'constitution de 1958' => [
                'constitution du 4 octobre 1958',
            ],
            'ddhc' => [
                'déclaration des droits de l\'homme et du citoyen',
                'déclaration du 26 août 1789',
            ],
            'préambule de 1946' => [
                'préambule de la constitution',
                'préambule du 27 octobre 1946',
            ],
            'charte de l\'environnement' => [
                'charte de 2004',
            ],
        ];

        $string = '
            constitution du 4 octobre 1958 
            constitution de 1958 
            préambule de 1946 
            préambule du 27 octobre 1946
        ';

        $output = $this->findStringsIn($values, $string);
        ldd($output);
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
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('décision-cadre ')
            ->append(Common::numero(Common::twoNumbers('/')->then('/JAI')))
            ->getRegExp();

        $string = 'la décision-cadre n° 2002/584/JAI';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function decisionCc($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->append(Common::numero(
                Common::twoNumbers()
                ->then(' ')
                ->anyOf(static::$typeDecisionsConstitutionnelles)
            ))
            ->getRegExp();

        $string = 'n° 2013-4793 AN';
        $string = 'la décision du Conseil constitutionnel n° 2009-577 DC du 3 mars 2009';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function deliberationCc($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('délibération du Conseil constitutionnel ')
            ->append(Common::duOuEndDateDu())
            ->getRegExp();

        $string = 'délibération du Conseil constitutionnel en date du 23 octobre 1987';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function reglementCeOuUe($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('règlement (')
            ->append($builder->getNew()->anyOf(['UE', 'CE']))
            ->asGroup('institution')
            ->then(') ')
            ->append(Common::numero(Common::twoNumbers('/')))
            ->getRegExp();

        $string = 'le règlement (UE) n° 1175/2011 ';
        $string = 'le règlement (CE) n° 1466/97 ';

        $output = $regExp->findIn($string);
        ldd($output);
    }

    public function reglementCc($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->then('règlement ')
            ->append(Common::duOuEndDateDu())
            ->anythingBut('constitutionnalité')
            ->getRegExp();

        $string = 'règlement du 4 février 2010 blalabla constitutionnalité';

        $output = $regExp->findIn($string);
    }

    public function decisionOuArretCedh($string)
    {
        $builder = new RegExpBuilder();
        
        $regExp = $builder->getNew()->ignoreCase()->globalMatch()
            ->anyOf(['arrêt', 'décision'])
            ->then(' de la Cour européenne des droits de l\'homme ')
            ->eitherFind(Common::numero(Common::twoNumbers('/')))
            ->orFind(Common::duOuEndDateDu())
            ->getRegExp();

        $string = 'l\'arrêt de la Cour européenne des droits de l\'homme n° 4774/98 (affaire Leyla Sahin c. Turquie) du 29 juin 2004 ;';
        $string = 'décision de la Cour européenne des droits de l\'homme du 15 janvier 2009';

        $string = '
            décision de la Cour européenne des droits de l\'homme du 15 janvier 2009 
            arrêt de la Cour européenne des droits de l\'homme n° 4774/98
        ';

        // later
        // $string = 'Dans sa décision ou dans son arrêt (date ou référence) la Cour européenne des droits de l'homme';
    
        $output = $regExp->findIn($string);
        ldd($output);
    }
}
