<?php

namespace Younes0\Reglex;

use Gherkins\RegExpBuilderPHP\RegExpBuilder;
use Illuminate\Support\Str;

class Utils
{   
    static public $methodsTranslation = [
       'loi'                 => 'loi',
       'decret'              => 'décrêt',
       'decretLoi'           => 'décrêt-loi',
       'ordonnance'          => 'ordonnance',
       'avis'                => 'avis',
       'arrete'              => 'arrêté',
       'arretCa'             => 'arrêt de la cour d\'appel',
       'jugementTribunal'    => 'jugement du tribunal',
       'arretCourCassation'  => 'arrêt de la cour de cassation',
       'arretCourJusticeUe'  => 'arrêt de la cour de justice européenne',
       'circulaire'          => 'circulaire',
       'directiveUe'         => 'directive européenne',
       'decisionClassiqueCe' => 'décision classique du Conseil d\'État',
       'decisionRenvoiCe'    => 'décision de renvoi du Conseil d\'État',
       'constitution'        => 'constitution',
       'convention'          => 'convention',
       'decisionCadreUe'     => 'décision-cadre éuropéenne',
       'decisionCc'          => 'décision de la cour constitutionnelle',
       'deliberationCc'      => 'délibération de la cour constitutionnelle',
       'reglementCeOuUe'     => 'réglement européen',
       'reglementCc'         => 'réglement de la cour constitutionnelle',
       'decisionOuArretCedh' => 'décision ou arrêt de la CEDH',
       'dccVisa'             => 'visa situé dans la décision',
       'dccConsiderant'      => 'considérant situé dans la décision',
       'dccMembres'          => 'membres de la décision',
       'refDocAuteurs'       => 'auteurs référencés',
       'dccOuCommentaireDccPremierParagraphe' => 'NULL',
       'membre' => 'membre',
    ];

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

    static public $juridictionsInternationales = [
        'Chambres extraordinaires au sein des tribunaux cambodgiens (CETC) et Assistance des Nations unies au procès des khmers rouges',
        'Cour internationale de justice',
        'Cour pénale internationale',
        'Tribunal international du droit de la mer',
        'Tribunal pénal international pour l\'ex-Yougoslavie',
        'Tribunal pénal international pour le Rwanda',
        'Tribunal spécial pour le Liban (TSL)',
        'Tribunal spécial résiduel pour la Sierra Leone',
    ];

    static public $traitesInternationaux = [
        'Acte constitutif du 16 novembre 1945 relatif à la Création de l\'UNESCO',
        'Charte des Nations Unies du 26 juin 1945',
        'Constitution de l\'Organisation internationale du Travail',
        'Convention de Berne du 24 juillet 1971 pour la protection des oeuvres litteraires et artistiques révisée',
        'Convention de Bruxelles du 27 septembre 1968 concernant la compétence judiciaire et l\'exécution des décisions en matière civile et commerciale',
        'Convention de Genève du 19 mars 1931 destinée à régler certains conflits de lois en matière de chèques',
        'Convention de Genève du 19 mars 1931 relative au droit de timbre en matière de chèques',
        'Convention de Genève du 21 avril 1961 sur l\'arbitrage commercial international',
        'Convention de Genève du 28 juillet 1951 sur les réfugiés',
        'Convention de Genève du 7 juin 1930 sur les lettres de change ',
        'Convention de la Haye du 14 mars 1978 sur la loi applicable aux contrats d\'intermédiaires et à la représentation',
        'Convention de la Haye du 1er mars 1954 relative à la procédure civile ',
        'Convention de la Haye du 25 octobre 1980 sur les aspects civils de l\'enlèvement international des enfants ',
        'Convention de la Haye du 25 octobre 1980 tendant à faciliter l\'accès international à la justice',
        'Convention de la Haye du 29 mai 1993 sur la coopération en matière d\'adoption internationale',
        'Convention de la Haye du 5 octobre 1961 supprimant l’exigence de la légalisation des actes publics étrangers du 5 octobre 1961 dite Apostille',
        'Convention de la Haye du 5 octobre 1961 sur la protection des mineurs ',
        'Convention de Lugano du 16 septembre 1988 concernant la compétence judiciaire et l\'exécution des décisions en matière civile et commerciale',
        'Convention de New York du 28 septembre 1954 sur le statut des apatrides, signée le 12 janvier 1955',
        'Convention de New-York du 10 juin 1958 sur la reconnaissance et l\'exécution des sentences arbitrales étrangères',
        'Convention de Paris de 1883 pour la protection de la propriété industrielle révisée',
        'Convention de Rome du 19 juin 1980 sur la loi applicable aux obligations contractuelles',
        'Convention de Vienne du 11 avril 1980 sur la vente internationale de marchandises ',
        'Convention de Vienne du 18 avril 1961 sur les relations diplomatiques ',
        'Convention de Vienne du 24 avril 1963 sur les relations consulaires',
        'Convention du 13 janvier 1993 sur l\'interdiction de la mise au point, de la fabrication, du stockage et de l\'emploi des armes chimiques et sur leur destruction',
        'Convention du 20 novembre 1989 relative aux droits de l\'enfant',
        'Convention du 4 décembre 1997 sur l\'interdiction de l\'emploi, du stockage, de la production et du transfert des mines antipersonnel et sur leur destruction ',
        'Convention européenne de sauvegarde des droits de l\'Homme du 4 novembre 1950',
        'Convention européenne de Strasbourg du 20 avril 1959 d\'entraide judiciaire en matière pénale',
        'Convention universelle du 24 juillet 1971 sur le droit d\'auteur ',
        'Conventions de Genève du 12 août 1949 ',
        'Déclaration universelle des droits de l\'homme du 10 décembre 1948 ',
        'Pacte du 16 décembre 1966 relatif aux droits civils et politiques ',
        'Pacte du 16 décembre 1966 relatif aux droits économiques, sociaux et culturels',
        'Statut du Conseil de l\'Europe du 5 mai 1949',
        'Traité de l\'Atlantique Nord du 4 avril 1949 ',
        'Traité du 1er juillet 1968 de non-proliférations sur les armes nucléaires ',
    ];

    static public $traitesEuropeens = [
        'Accord complémentaire pour l\'application de la Convention européenne de sécurité sociale',
        'Accord entre les Etats membres du Conseil de l\'Europe sur l\'attribution aux mutilés de guerre militaires et civils d\'un carnet international de bons de réparation d\'appareils de prothèse et d\'orthopédie ',
        'Accord européen concernant l\'entraide médicale dans le domaine des traitements spéciaux et des ressources thermo-climatiques',
        'Accord européen concernant les personnes participant aux procédures devant la Commission et la Cour européennes des Droits de l\'Homme',
        'Accord européen concernant les personnes participant aux procédures devant la Cour européenne des Droits de l\'Homme',
        'Accord européen pour la répression des émissions de radiodiffusion effectuées par des stations hors des territoires nationaux',
        'Accord européen relatif à l\'échange de substances thérapeutiques d\'origine humaine ',
        'Accord européen relatif à l\'échange des réactifs pour la détermination des groupes sanguins',
        'Accord européen relatif à la suppression des visas pour les réfugiés',
        'Accord européen sur l\'instruction et la formation des infirmières',
        'Accord européen sur l\'échange de réactifs pour la détermination des groupes tissulaires',
        'Accord européen sur la circulation des jeunes sous couvert du passeport collectif entre les pays membres du Conseil de l\'Europe',
        'Accord européen sur la limitation de l\'emploi de certains détergents dans les produits de lavage et de nettoyage',
        'Accord européen sur la transmission des demandes d\'assistance judiciaire',
        'Accord européen sur le maintien du paiement des bourses aux étudiants poursuivant leurs études à l\'étranger',
        'Accord européen sur le placement au pair',
        'Accord européen sur le régime de la circulation des personnes entre les pays membres du Conseil de l\'Europe',
        'Accord européen sur le transfert de la responsabilité à l\'égard des réfugiés',
        'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Accord intérimaire européen concernant la sécurité sociale à l\'exclusion des régimes relatifs à la vieillesse, à l\'invalidité et aux survivants',
        'Accord intérimaire européen concernant les régimes de sécurité sociale relatifs à la vieillesse, à l\'invalidité et aux survivants',
        'Accord pour l\'importation temporaire en franchise de douane, à titre de prêt gratuit et à des fins diagnostiques ou thérapeutiques, de matériel médico-chirurgical et de laboratoire destiné aux établissements sanitaires ',
        'Accord relatif au trafic illicite par mer, mettant en oeuvre l\'article 17 de la Convention des Nations Unies contre le trafic illicite de stupéfiants et de substances psychotropes',
        'Accord sur l\'échange des mutilés de guerre entre les pays membres du Conseil de l\'Europe aux fins de traitement médical',
        'Accord sur le transfert des corps des personnes décédées',
        'Arrangement européen pour la protection des émissions de télévision',
        'Arrangement européen sur l\'échange des programmes au moyen de films de télévision',
        'Arrangement pour l\'application de l\'Accord européen du 17 octobre 1980 concernant l\'octroi des soins médicaux aux personnes en séjour temporaire',
        'Arrangement relatif à l\'application de la Convention européenne sur l\'arbitrage commercial international',
        'Charte européenne de l\'autonomie locale',
        'Charte européenne des langues régionales ou minoritaires',
        'Charte sociale européenne (révisée)',
        'Charte sociale européenne',
        'Cinquième Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Code européen de sécurité sociale (révisé) ',
        'Code européen de sécurité sociale',
        'Convention civile sur la corruption',
        'Convention concernant l\'assistance administrative mutuelle en matière fiscale',
        'Convention contre le dopage',
        'Convention contre le dopageLink URL',
        'Convention culturelle européenne',
        'Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Convention du Conseil de l\'Europe pour la prévention du terrorisme ',
        'Convention du Conseil de l\'Europe relative au blanchiment, au dépistage, à la saisie et à la confiscation des produits du crime et au financement du terrorisme',
        'Convention du Conseil de l\'Europe sur l\'accès aux documents publics',
        'Convention du Conseil de l\'Europe sur la contrefaçon des produits médicaux et les infractions similaires menaçant la santé publique',
        'Convention du Conseil de l\'Europe sur la lutte contre la traite des êtres humains',
        'Convention du Conseil de l\'Europe sur la protection des enfants contre l\'exploitation et les abus sexuels',
        'Convention du Conseil de l’Europe contre le trafic d’organes humains',
        'Convention du Conseil de l’Europe sur la manipulation de compétitions sportives',
        'Convention du Conseil de l’Europe sur la prévention des cas d’apatridie en relation avec la succession d’Etats ',
        'Convention du Conseil de l’Europe sur la prévention et la lutte contre la violence à l’égard des femmes et la violence domestique',
        'Convention européenne concernant des questions de droit d\'auteur et de droits voisins dans le cadre de la radiodiffusion transfrontière par satellite',
        'Convention européenne d\'assistance sociale et médicale ',
        'Convention européenne d\'entraide judiciaire en matière pénale',
        'Convention européenne d\'extradition',
        'Convention européenne d\'établissement des sociétés ',
        'Convention européenne d\'établissement',
        'Convention européenne dans le domaine de l\'information sur le droit étranger',
        'Convention européenne de sécurité sociale',
        'Convention européenne du paysage',
        'Convention européenne en matière d\'adoption des enfants (révisée)',
        'Convention européenne en matière d\'adoption des enfants',
        'Convention européenne portant loi uniforme en matière d\'arbitrage',
        'Convention européenne pour la protection des animaux de compagnie',
        'Convention européenne pour la protection du patrimoine archéologique (révisée) ',
        'Convention européenne pour la protection du patrimoine archéologique',
        'Convention européenne pour la prévention de la torture et des peines ou traitements inhumains ou dégradants',
        'Convention européenne pour la répression des infractions routières ',
        'Convention européenne pour la répression du terrorisme ',
        'Convention européenne pour la surveillance des personnes condamnées ou libérées sous condition ',
        'Convention européenne pour le règlement pacifique des différends',
        'Convention européenne relative au dédommagement des victimes d\'infractions violentes',
        'Convention européenne relative au lieu de paiement des obligations monétaires',
        'Convention européenne relative au statut juridique du travailleur migrant',
        'Convention européenne relative aux formalités prescrites pour les demandes de brevets',
        'Convention européenne relative aux obligations en monnaie étrangère',
        'Convention européenne relative à l\'assurance obligatoire de la responsabilité civile en matière de véhicules automoteurs',
        'Convention européenne relative à l\'équivalence des diplômes donnant accès aux établissements universitaires',
        'Convention européenne relative à la protection du patrimoine audiovisuel',
        'Convention européenne relative à la protection sociale des agriculteurs',
        'Convention européenne relative à la suppression de la légalisation des actes établis par les agents diplomatiques ou consulaires',
        'Convention européenne sur certains aspects internationaux de la faillite',
        'Convention européenne sur l\'exercice des droits des enfants',
        'Convention européenne sur l\'immunité des Etats ',
        'Convention européenne sur l\'imprescriptibilité des crimes contre l\'humanité et des crimes de guerre',
        'Convention européenne sur l\'obtention à l\'étranger d\'informations et de preuves en matière administrative',
        'Convention européenne sur l\'équivalence des périodes d\'études universitaires',
        'Convention européenne sur l\'équivalence générale des périodes d\'études universitaires',
        'Convention européenne sur la classification internationale des brevets d\'invention ',
        'Convention européenne sur la computation des délais',
        'Convention européenne sur la coproduction cinématographique',
        'Convention européenne sur la nationalité',
        'Convention européenne sur la notification à l\'étranger des documents en matière administrative ',
        'Convention européenne sur la promotion d\'un service volontaire transnational à long-terme pour les jeunes',
        'Convention européenne sur la protection des animaux d\'abattage ',
        'Convention européenne sur la protection des animaux dans les élevages',
        'Convention européenne sur la protection des animaux en transport international ',
        'Convention européenne sur la protection des animaux en transport international (révisée)',
        'Convention européenne sur la protection des animaux vertébrés utilisés à des fins expérimentales ou à d\'autres fins scientifiques',
        'Convention européenne sur la protection juridique des services à accès conditionnel et des services d\'accès conditionnel',
        'Convention européenne sur la reconnaissance académique des qualifications universitaires',
        'Convention européenne sur la reconnaissance de la personnalité juridique des organisations internationales non gouvernementales',
        'Convention européenne sur la reconnaissance et l\'exécution des décisions en matière de garde des enfants et le rétablissement de la garde des enfants',
        'Convention européenne sur la responsabilité civile en cas de dommages causés par des véhicules automoteurs ',
        'Convention européenne sur la responsabilité du fait des produits en cas de lésions corporelles ou de décès ',
        'Convention européenne sur la transmission des procédures répressives',
        'Convention européenne sur la télévision transfrontière ',
        'Convention européenne sur la valeur internationale des jugements répressifs',
        'Convention européenne sur la violence et les débordements de spectateurs lors de manifestations sportives et notamment de matches de football',
        'Convention européenne sur le contrôle de l\'acquisition et de la détention d\'armes à feu par des particuliers',
        'Convention européenne sur le rapatriement des mineurs',
        'Convention européenne sur le statut juridique des enfants nés hors mariage ',
        'Convention européenne sur les effets internationaux de la déchéance du droit de conduire un véhicule à moteur',
        'Convention européenne sur les fonctions consulaires',
        'Convention européenne sur les infractions visant des biens culturels',
        'Convention pour la protection des Droits de l\'Homme et de la dignité de l\'être humain à l\'égard des applications de la biologie et de la médecine: Convention sur les Droits de l\'Homme et la biomédecine',
        'Convention pour la protection des personnes à l\'égard du traitement automatisé des données à caractère personnel',
        'Convention pour la sauvegarde du patrimoine architectural de l\'Europe',
        'Convention pénale sur la corruption',
        'Convention relative au blanchiment, au dépistage, à la saisie et à la confiscation des produits du crime',
        'Convention relative à l\'opposition sur titres au porteur à circulation internationale',
        'Convention relative à l\'élaboration d\'une pharmacopée européenne',
        'Convention relative à l\'établissement d\'un système d\'inscription des testaments',
        'Convention relative à la conservation de la vie sauvage et du milieu naturel de l\'Europe',
        'Convention sur l\'information et la coopération juridique concernant les "Services de la Société de l\'Information"',
        'Convention sur l\'unification de certains éléments du droit des brevets d\'invention ',
        'Convention sur la cybercriminalité ',
        'Convention sur la participation des étrangers à la vie publique au niveau local',
        'Convention sur la protection de l\'environnement par le droit pénal ',
        'Convention sur la reconnaissance des qualifications relatives à l\'enseignement supérieur dans la région européenne ',
        'Convention sur la responsabilité civile des dommages résultant d\'activités dangereuses pour l\'environnement',
        'Convention sur la responsabilité des hôteliers quant aux objets apportés par les voyageurs ',
        'Convention sur la réduction des cas de pluralité de nationalités et sur les obligations militaires en cas de pluralité de nationalités ',
        'Convention sur le transfèrement des personnes condamnées',
        'Convention sur les opérations financières des «initiés»',
        'Convention sur les relations personnelles concernant les enfants',
        'Convention-cadre du Conseil de l\'Europe sur la valeur du patrimoine culturel pour la société',
        'Convention-cadre européenne sur la coopération transfrontalière des collectivités ou autorités territoriales',
        'Convention-cadre pour la protection des minorités nationales',
        'Deuxième Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Deuxième Protocole additionnel à la Convention européenne d\'entraide judiciaire en matière pénale',
        'Deuxième Protocole additionnel à la Convention européenne d\'extradition',
        'Deuxième Protocole portant modification à la Convention sur la réduction des cas de pluralité de nationalités et sur les obligations militaires en cas de pluralité de nationalités',
        'Protocole additionnel au Protocole à l\'Arrangement européen pour la protection des émissions de télévision ',
        'Protocole additionnel au Protocole à l\'Arrangement européen pour la protection des émissions de télévision ',
        'Protocole additionnel à l\'Accord européen relatif à l\'échange de substances thérapeutiques d\'origine humaine',
        'Protocole additionnel à l\'Accord européen relatif à l\'échange des réactifs pour la détermination des groupes sanguins',
        'Protocole additionnel à l\'Accord européen sur l\'échange de réactifs pour la détermination des groupes tissulaires',
        'Protocole additionnel à l\'Accord européen sur la transmission des demandes d\'assistance judiciaire ',
        'Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Protocole additionnel à l\'Accord intérimaire européen concernant la sécurité sociale à l\'exclusion des régimes relatifs à la vieillesse, à l\'invalidité et aux survivants',
        'Protocole additionnel à l\'Accord intérimaire européen concernant les régimes de sécurité sociale relatifs à la vieillesse, à l\'invalidité et aux survivants',
        'Protocole additionnel à l\'Accord pour l\'importation temporaire en franchise de douane, à titre de prêt gratuit et à des fins diagnostiques ou thérapeutiques, de matériel médico-chirurgical et de laboratoire destiné aux établissements sanitaires',
        'Protocole additionnel à la Charte européenne de l\'autonomie locale sur le droit de participer aux affaires des collectivités locales',
        'Protocole additionnel à la Charte sociale européenne prévoyant un système de réclamations collectives',
        'Protocole additionnel à la Charte sociale européenne',
        'Protocole additionnel à la Convention contre le dopage ',
        'Protocole additionnel à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole additionnel à la Convention du Conseil de l’Europe pour la prévention du terrorisme',
        'Protocole additionnel à la Convention européenne d\'assistance sociale et médicale',
        'Protocole additionnel à la Convention européenne d\'entraide judiciaire en matière pénale',
        'Protocole additionnel à la Convention européenne d\'extradition ',
        'Protocole additionnel à la Convention européenne dans le domaine de l\'information sur le droit étranger',
        'Protocole additionnel à la Convention européenne relative à l\'équivalence des diplômes donnant accès aux établissements universitaires ',
        'Protocole additionnel à la Convention européenne sur l\'immunité des Etats',
        'Protocole additionnel à la Convention européenne sur la protection des animaux en transport international',
        'Protocole additionnel à la Convention pour la protection des Droits de l\'Homme et de la dignité de l\'être humain à l\'égard des applications de la biologie et de la médecine, portant interdiction du clonage d\'êtres humains',
        'Protocole additionnel à la Convention pour la protection des personnes à l\'égard du traitement automatisé des données à caractère personnel, concernant les autorités de contrôle et les flux transfrontières de données',
        'Protocole additionnel à la Convention pénale sur la corruption ',
        'Protocole additionnel à la Convention sur la cybercriminalité, relatif à l\'incrimination d\'actes de nature raciste et xénophobe commis par le biais de systèmes informatiques',
        'Protocole additionnel à la Convention sur la réduction des cas de pluralité de nationalités et sur les obligations militaires en cas de pluralité de nationalités',
        'Protocole additionnel à la Convention sur le transfèrement des personnes condamnées',
        'Protocole additionnel à la Convention sur les Droits de l\'Homme et la biomédecine relatif à la transplantation d\'organes et de tissus d\'origine humaine',
        'Protocole additionnel à la Convention sur les Droits de l\'Homme et la biomédecine, relatif à la recherche biomédicale',
        'Protocole additionnel à la Convention sur les Droits de l’Homme et la biomédecine relatif aux tests génétiques à des fins médicales',
        'Protocole additionnel à la Convention-cadre européenne sur la coopération transfrontalière des collectivités ou autorités territoriales',
        'Protocole au Code européen de sécurité sociale ',
        'Protocole d\'amendement à la Convention concernant l\'assistance administrative mutuelle en matière fiscale',
        'Protocole d\'amendement à la Convention européenne sur la protection des animaux dans les élevages',
        'Protocole d\'amendement à la Convention européenne sur la protection des animaux vertébrés utilisés à des fins expérimentales ou à d\'autres fins scientifiques',
        'Protocole no. 1 à la Convention européenne pour la prévention de la torture et des peines ou traitements inhumains ou dégradants',
        'Protocole no. 10 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales ',
        'Protocole no. 11 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, portant restructuration du mécanisme de contrôle établi par la Convention',
        'Protocole no. 2 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, attribuant à la Cour européenne des Droits de l\'Homme la compétence de donner des avis consultatifs ',
        'Protocole no. 2 à la Convention européenne pour la prévention de la torture et des peines ou traitements inhumains ou dégradants',
        'Protocole no. 2 à la Convention-cadre européenne sur la coopération transfrontalière des collectivités ou autorités territoriales relatif à la coopération interterritoriale',
        'Protocole no. 3 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, modifiant les articles 29, 30 et 34 de la Convention',
        'Protocole no. 4 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, reconnaissant certains droits et libertés autres que ceux figurant déjà dans la Convention et dans le premier Protocole additionnel à la Convention ',
        'Protocole no. 5 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, modifiant les articles 22 et 40 de la Convention',
        'Protocole no. 6 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales concernant l\'abolition de la peine de mort',
        'Protocole no. 7 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole no. 8 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole no. 9 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole n° 12 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole n° 13 à la Convention  de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, relatif à l\'abolition de la peine de mort en toutes circonstances',
        'Protocole n° 14 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales, amendant le système de contrôle de la Convention',
        'Protocole n° 14bis à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole n° 15 portant amendement à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole n° 16 à la Convention de sauvegarde des Droits de l\'Homme et des Libertés fondamentales',
        'Protocole n° 3 à la Convention-cadre européenne sur la coopération transfrontalière des collectivités ou autorités territoriales relatif aux Groupements eurorégionaux de coopération (GEC)',
        'Protocole portant amendement à l\'Accord européen sur la limitation de l\'emploi de certains détergents dans les produits de lavage et de nettoyage',
        'Protocole portant amendement à la Charte sociale européenne',
        'Protocole portant amendement à la Convention européenne pour la répression du terrorisme',
        'Protocole portant amendement à la Convention européenne sur la télévision transfrontière',
        'Protocole portant modification à la Convention sur la réduction des cas de pluralité de nationalités et sur les obligations militaires en cas de pluralité de nationalités ',
        'Protocole à l\'Arrangement européen pour la protection des émissions de télévision',
        'Protocole à la Convention européenne de sécurité sociale',
        'Protocole à la Convention européenne relative à la protection du patrimoine audiovisuel, sur la protection des productions télévisuelles',
        'Protocole à la Convention européenne sur les fonctions consulaires relatif aux fonctions consulaires en matière d\'aviation civile',
        'Protocole à la Convention européenne sur les fonctions consulaires relatif à la protection des réfugiés',
        'Protocole à la Convention relative à l\'élaboration d\'une pharmacopée européenne',
        'Protocole à la Convention sur les opérations financières des «initiés» ',
        'Quatrième Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Quatrième Protocole additionnel à la Convention européenne d\'extradition',
        'Sixième Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Statut du Conseil de l\'Europe',
        'Traité sur l\'Union européenne',
        'Traité sur le fonctionnement de l\'Union européenne',
        'Traité instituant la Communauté européenne de l\'énergie atomique',
        'Charte des droits fondamentaux de l\'Union européenne',
        'Traité de Lisbonne modifiant le traité sur l\'Union européenne et le traité instituant la Communauté européenne',
        'Troisième Protocole additionnel au Protocole à l\'Arrangement européen pour la protection des émissions de télévision',
        'Troisième Protocole additionnel à l\'Accord général sur les privilèges et immunités du Conseil de l\'Europe',
        'Troisième Protocole additionnel à la Convention européenne d\'extradition',
    ];
}
