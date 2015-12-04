<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Utils
{   
    static public $mois = [
        'janvier',
        'février',
        'mars',
        'avril',
        'mai',
        'juin',
        'juillet',
        'août',
        'septembre',
        'octobre',
        'novembre',
        'décembre',
    ];

    static public $titresCivilite = [
        'Mmes', 
        'Mme', 
        'MM', 
        'MR', 
        'M',
    ];

    static public $coursDappel = [ 
        'Agen',
        'Aix-en-Provence',
        'Amiens',
        'Angers',
        'Basse-Terre',
        'Bastia',
        'Besançon',
        'Bordeaux',
        'Bourges',
        'Caen',
        'Cayenne',
        'Chambéry',
        'Colmar',
        'Dijon',
        'Douai',
        'Fort-de-France',
        'Grenoble',
        'Limoges',
        'Lyon',
        'Metz',
        'Montpellier',
        'Nancy',
        'Nouméa',
        'Nîmes',
        'Orléans',
        'Papeete',
        'Paris',
        'Pau',
        'Poitiers',
        'Reims',
        'Rennes',
        'Riom',
        'Rouen',
        'Saint-Denis',
        'Saint-Denis-de-la-Réunion',
        'Toulouse',
        'Versailles',
    ];

    static public $codesFr = [
        'code civil',
        'code de commerce',
        'code de construction des appareils à pression non soumis à la flamme',
        'code de déontologie de la police nationale',
        'code de déontologie des activités privées de sécurité',
        'code de déontologie des avocats',
        'code de déontologie des psychologues',
        'code de déontologie médicale',
        'code de déontologie',
        'code de justice administrative',
        'code de l\'action sociale et des familles',
        'code de l\'artisanat',
        'code de l\'aviation civile',
        'code de l\'entrée et du séjour des étrangers et du droit d\'asile',
        'code de l\'environnement',
        'code de l\'expropriation pour cause d\'utilité publique',
        'code de l\'organisation judiciaire',
        'code de l\'urbanisme',
        'code de l\'éducation',
        'code de l\'énergie',
        'code de la consommation',
        'code de la construction et de l\'habitation',
        'code de la défense',
        'code de la famille et de l\'aide sociale',
        'code de la mutualité',
        'code de la propriété intellectuelle',
        'code de la recherche',
        'code de la route en france',
        'code de la santé publique',
        'code de la sécurité intérieure',
        'code de la sécurité sociale',
        'code de la voirie routière',
        'code de procédure civile',
        'code de procédure pénale',
        'code des assurances',
        'code des douanes',
        'code des juridictions financières',
        'code des marchés publics',
        'code des postes et des communications électroniques',
        'code des procédures civiles d\'exécution',
        'code des transports',
        'code du cinéma et de l\'image animée',
        'code du patrimoine',
        'code du sport',
        'code du tourisme',
        'code du travail',
        'code forestier',
        'code général de la propriété des personnes publiques',
        'code général des collectivités territoriales',
        'code général des impôts',
        'code monétaire et financier',
        'code pénal',
        'code rural et de la pêche maritime',
        'code électoral',
        'codes napoléoniens',
        'dossier de consultation des entreprises',
        'droit des marchés publics en france',
        'droit minier',
        'livre des procédures fiscales',
    ];

    // later: à compléter
    static public $institutions = [
        'Assemblée territoriale de la Polynésie française',
        'Commission nationale de l\'informatique et des libertés',
        'Président de l\'Assemblée nationale',
    ];

    static public $typeDecisionsConstitutionnelles = [ 
        'ART16',
        'AUTR',
        'ELEC',
        'FNR',
        'LOM',
        'ORGA',
        'PDR',
        'QPC',
        'REF',
        'SEN',
        'AN',
        'DC',
        'LP',
        'I',
        'L',
        'D',
    ];

    static public $constitutions = [ 
        'constitution 1958' => [
            'constitution de 1958',
            'constitution du 4 octobre 1958',
        ],
        'ddhc' => [
            'déclaration des droits de l\'homme et du citoyen',
            'déclaration du 26 août 1789',
        ],
        'préambule 1946' => [
            'préambule de 1946',
            'préambule de la constitution',
            'préambule du 27 octobre 1946',
        ],
        'charte environnement' => [
            'charte de l\'environnement',
            'charte de 2004',
        ],
    ];

    static public $conventions = [ 
        'convention genève 1951' => [
            'la Convention de Genève du 28 juillet 1951',
        ],
        'convention rome 1950' => [
            'Convention de sauvegarde des droits de l\'homme et des libertés fondamentales',
        ],
    ];
}
