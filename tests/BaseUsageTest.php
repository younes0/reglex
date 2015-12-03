<?php

namespace Younes0\Reglex\Test;

use Younes0\Reglex\Base;

class BaseUsageTest extends \PHPUnit_Framework_TestCase
{
    protected $b;

    public function setUp()
    {        
        $this->b = new Base();
    }

    public function testLoi()
    {
        $v = $this->b->loi('
            L. 2111-4; 
            LO. 1-1 du code général de la propriété des personnes publiques; 
            loi organique n° 2-2;
        ');

        $this->assertEquals($v['numero'][0], '2111-4');
        $this->assertEquals($v['numero'][1], '1-1');
        $this->assertEquals($v['numero'][2], '2-2');
        $this->assertEquals($v['organique'][0], false);
        $this->assertEquals($v['organique'][1], true);
        $this->assertEquals($v['organique'][2], true);
        $this->assertEquals($v['code'][1], 'code général de la propriété des personnes publiques');
    }
        
    public function testDecret() 
    {
        // tests
        $string = 'le décret n° 86-451';
        $string = 'décret n° 2006-1231';
    }
        
    public function testDecretLoi() 
    {

        // tests
        $string = 'décret-loi du 24 mai 1938';
    }
        
    public function testOrdonnance() 
    {

        // tests
        $string = 'ordonnance n° 58-1067';
        $string = 'ordonnance du 7 novembre 1958';
    }
        
    public function testAvis() 
    {

        // tests
        $string = 'l\'avis de l\'Assemblée territoriale de la Polynésie française en date du 25 novembre 1993';
        $string = 'l\'avis de la Commission nationale de l\'informatique et des libertés';
    }
        
    public function testArrete() 
    {

        $string = 'l\'arrêté du 12 février 2010';
        $string = 'l\'arrêté interministériel n° 1802 du 29 juin 1979';
    }
        
    public function testArretCa() 
    {

        $string = 'l\'arrêt de la cour d\'appel de Lyon';
        $string = 'l\'arrêt de la cour d\'appel de Lyon, en date du 14 décembre 1994';
        $string = 'l\'arrêt de la cour d\'appel de Saint-Denis-de-la-Réunion, siégeant en matière civile, en date du 14 décembre 1994';
    }
        
    public function testJugementTribunal() 
    {
        $string = 'le jugement du tribunal de grande instance d\'Argentan';
        $string = 'le jugement du tribunal de commerce, en date du 7 novembre 1995';
        $string = 'le jugement du tribunal de grande instance d\'Argentan, siégeant en matière correctionnelle, en date du 7 novembre 1995';
    }
        
    public function testArretCourCassation() 
    {

        $string = 'Vu l\'arrêt de la Cour de cassation en date du 7 décembre 1995';
        $string = 'Vu l\'arrêt de la Cour de cassation (chambre criminelle) du 30 novembre 2005';

    }
        
    public function testArretCourJusticeUe() 
    {
        $string = 'l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° C-168/13 PPU ;';
        $string = 'l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° T-175/04 PPU ;';
    }
        
    public function testCirculaire() 
    {
        $string = 'la circulaire du ministre de l\'intérieur et de la sécurité publique du 26 janvier 1993 relative à l\'organisation des élections législatives des 21 et 28 mars 1993;';
        $string = 'la circulaire du ministre de l\'intérieur relative à l\'envoi des formulaires de présentation d\'un candidat à l\'élection présidentielle;';
    }
        
    public function testConvention() 
    {
        $string = 'la Convention de Genève du 28 juillet 1951 relative au statut des réfugiés et le protocole signé à New York le 31 janvier 1967 ;';
        // $string = 'la Convention de sauvegarde des droits de l\'homme et des libertés fondamentales ;';
        // $string = 'La Convention de sauvegarde des droits de l\'homme et des libertés fondamentales, signée à Rome le 4 novembre 1950 ;';
    }
        
    public function testDirectiveUe() 
    {

        $string = 'la directive 2003/54/CE';
    }
        
    public function testDecisionClassiqueCe() 
    {

        $string = 'la décision du Conseil d\'État n° 222160 du 30 juin 2003';
        // $string = 'la décision du Conseil d\'État nos 265582 et 273093 du 13 mars 2006 ;';
    }
        
    public function testDecisionRenvoiCe() 
    {

        $string = 'par le Conseil d\'Etat (décision n° 387472 du même jour) ;';
        // $string = 'par le Conseil d\'Etat Conseil d\'État (décision nos 380743, 380744 et 380745 du 23 juillet 2014) ;';
    }
        
    public function testConstitution() 
    {
        $string = '
            constitution du 4 octobre 1958 
            constitution de 1958 
            préambule de 1946 
            préambule du 27 octobre 1946
        ';
    }
        
    public function testDecisionCadreUe()    
    {
        $string = 'la décision-cadre n° 2002/584/JAI';
    }
        
    public function testDecisionCc() 
    {

        $string = 'n° 2013-4793 AN';
        $string = 'la décision du Conseil constitutionnel n° 2009-577 DC du 3 mars 2009';
    }
        
    public function testDeliberationCc() 
    {

        $string = 'délibération du Conseil constitutionnel en date du 23 octobre 1987';
    }
        
    public function testReglementCeOuUe() 
    {

        $string = 'le règlement (UE) n° 1175/2011 ';
        $string = 'le règlement (CE) n° 1466/97 ';
    }
        
    public function testReglementCc() 
    {

        $string = 'règlement du 4 février 2010 blalabla constitutionnalité';
    }
        
    public function testDecisionOuArretCedh()
    {

        $string = 'l\'arrêt de la Cour européenne des droits de l\'homme n° 4774/98 (affaire Leyla Sahin c. Turquie) du 29 juin 2004 ;';
        $string = 'décision de la Cour européenne des droits de l\'homme du 15 janvier 2009';

        $string = '
            décision de la Cour européenne des droits de l\'homme du 15 janvier 2009 
            arrêt de la Cour européenne des droits de l\'homme n° 4774/98
        ';

        // later
        // $string = 'Dans sa décision ou dans son arrêt (date ou référence) la Cour européenne des droits de l'homme';
    }
}
