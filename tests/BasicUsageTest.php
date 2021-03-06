<?php

namespace Younes0\Reglex\Test;

use Younes0\Reglex\Basic;

class BasicUsageTest extends \PHPUnit_Framework_TestCase
{
    protected $base;

    public function testLoi()
    {
        $string = '
            L. 2111-4; 
            LO. 1-1 du code général de la propriété des personnes publiques; 
            loi organique n° 2-2;
        ';

        $v = (new Basic($string))->loi();

        $this->assertEquals($v[0]['numero'], '2111-4');
        $this->assertEquals($v[1]['numero'], '1-1');
        $this->assertEquals($v[2]['numero'], '2-2');
        $this->assertEquals($v[0]['organique'], false);
        $this->assertEquals($v[1]['organique'], true);
        $this->assertEquals($v[2]['organique'], true);
        $this->assertEquals($v[1]['code'], 'code général de la propriété des personnes publiques');
    }
        
    public function testDecret() 
    {
        $string = '
            le décret n° 86-451 
            décret n° 2006-1231
        ';

        $v = (new Basic($string))->decret();

        $this->assertEquals($v[0]['numero'], '86-451');
        $this->assertEquals($v[1]['numero'], '2006-1231');
    }
        
    public function testDecretLoi() 
    {
        $string = '
            décret-loi du 24 mai 1938
        ';

        $v = (new Basic($string))->decretLoi();

        $this->assertEquals($v[0]['date'], '24 mai 1938');
    }
        
    public function testOrdonnance() 
    {
        $string = '
            ordonnance n° 58-1067
            ordonnance du 7 novembre 1958
        ';

        $v = (new Basic($string))->ordonnance();

        $this->assertEquals($v[0]['numero'], '58-1067');
        $this->assertEquals($v[1]['date'], '7 novembre 1958');
    }
        
    public function testAvis() 
    {
        $string = '
            l\'avis de la Assemblée territoriale de la Polynésie française en date du 25 novembre 1993 
            l\'avis de la Commission nationale de l\'informatique et des libertés 
            avis du Président de l\'Assemblée nationale inséré au Journal officiel de la République française du 16 mars 2007
        ';

        $v = (new Basic($string))->avis();

        $this->assertEquals($v[0]['institution'], 'Assemblée territoriale de la Polynésie française');
        $this->assertEquals($v[0]['date'], '25 novembre 1993');
        $this->assertEquals($v[1]['institution'], 'Commission nationale de l\'informatique et des libertés');
        $this->assertEquals($v[2]['institution'], 'Président de l\'Assemblée nationale');
    }
        
    public function testArrete() 
    {
        $string = '
            l\'arrêté du 12 février 2010
            l\'arrêté interministériel n° 1802 du 29 juin 1979
        ';

        $v = (new Basic($string))->arrete();

        $this->assertEquals($v[0]['date'], '12 février 2010');
        $this->assertEquals($v[1]['date'], '29 juin 1979');
        $this->assertEquals($v[1]['numero'], '1802');
        $this->assertEquals($v[1]['source'], 'interministériel');
    }

    public function testArretCa() 
    {
        $string = '
            l\'arrêt de la cour d\'appel de Lyon
            l\'arrêt de la cour d\'appel de Lyon, en date du 14 décembre 1994
            l\'arrêt de la cour d\'appel de Saint-Denis-de-la-Réunion, siégeant en matière civile, en date du 14 décembre 1994
        ';

        $v = (new Basic($string))->arretCa();

        $this->assertEquals($v[0]['ville'], 'Lyon');
        $this->assertEquals($v[1]['ville'], 'Lyon');
        $this->assertEquals($v[1]['date'], '14 décembre 1994');
        $this->assertEquals($v[2]['ville'], 'Saint-Denis-de-la-Réunion');
        $this->assertEquals($v[2]['date'], '14 décembre 1994');
        $this->assertEquals($v[2]['matiere'], 'civile');
    }
        
    public function testJugementTribunal() 
    {
        $string = '
            le jugement du tribunal de grande instance d\'Argentan,
            le jugement du tribunal de commerce, en date du 7 novembre 1995
            le jugement du tribunal de grande instance d\'Argentan, siégeant en matière correctionnelle, en date du 7 novembre 1995
        ';

        $v = (new Basic($string))->jugementTribunal();

        $this->assertEquals($v[0]['tribunal'], 'grande instance d\'Argentan');
        $this->assertEquals($v[1]['tribunal'], 'commerce');
        $this->assertEquals($v[1]['date'], '7 novembre 1995');
        $this->assertEquals($v[2]['matiere'], 'correctionnelle');
        $this->assertEquals($v[2]['date'], '7 novembre 1995');
    }
        
    public function testArretCourCassation() 
    {
        $string = '
            Vu l\'arrêt de la Cour de cassation en date du 7 décembre 1995
            l\'arrêt de la Cour de cassation (chambre criminelle) du 30 novembre 2005
        ';

        $v = (new Basic($string))->arretCourCassation();

        $this->assertEquals($v[0]['date'], '7 décembre 1995');
        $this->assertEquals($v[1]['date'], '30 novembre 2005');
        $this->assertEquals($v[1]['chambre'], 'criminelle');
    }
        
    public function testArretCourJusticeUe() 
    {
        $string = '
            l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° C-168/13 PPU
            arrêt de la Cour de justice de l\'Union européenne n° T-175/04 PPU
        ';

        $v = (new Basic($string))->arretCourJusticeUe();

        $this->assertEquals($v[0]['date'], '30 mai 2013');
        $this->assertEquals($v[0]['numero'], 'C-168/13 PPU');
        $this->assertEquals($v[1]['numero'], 'T-175/04 PPU');
    }
        
    public function testCirculaire() 
    {
        $string = '
            la circulaire du ministre de l\'intérieur et de la sécurité publique du 26 janvier 1993 relative à l\'organisation des élections législatives des 21 et 28 mars 1993;
            la circulaire du ministre de l\'intérieur relative à l\'envoi des formulaires de présentation d\'un candidat à l\'élection présidentielle;
        ';

        $v = (new Basic($string))->circulaire();

        $this->assertEquals($v[0]['institution'], 'ministre de l\'intérieur et de la sécurité publique');
        $this->assertEquals($v[0]['date'], '26 janvier 1993');
        $this->assertEquals($v[1]['institution'], 'ministre de l\'intérieur');
    }
        
    public function testDirectiveUe() 
    {
        $string = '
            la directive 2003/54/CE 
            la directive 23/54/CE 
        ';

        $v = (new Basic($string))->directiveUe();

        $this->assertEquals($v[0]['numero'], '2003/54/CE');
        $this->assertEquals($v[1]['numero'], '23/54/CE');
    }
    
    public function testDecisionClassiqueCe() 
    {
        $string = '
            la décision du Conseil d\'État n° 222160 du 30 juin 2003
            la décision du Conseil d\'État nos 265582 et 273093 du 13 mars 2006
        ';

        $v = (new Basic($string))->decisionClassiqueCe();

        $this->assertEquals($v[0]['numero'], '222160');
        $this->assertEquals($v[0]['date'], '30 juin 2003');
    }
        
    public function testDecisionRenvoiCe() 
    {
        $string = '
            par le Conseil d\'Etat (décision n° 387472 du même jour) 
            par le Conseil d\'Etat Conseil d\'État (décision nos 380743, 380744 et 380745 du 23 juillet 2014) 
        ';

        $v = (new Basic($string))->decisionRenvoiCe();

        $this->assertEquals($v[0]['numero'], '387472');
    }
        
    public function testConstitution() 
    {
        $string = '
            constitution du 4 octobre 1958 
            constitution de 1958 
            préambule du 27 octobre 1946
        ';

        $v = (new Basic($string))->constitution();

        $this->assertEquals($v[0]['id'], 'constitution 1958');
        $this->assertEquals($v[2]['id'], 'préambule 1946');
    }

    public function testConvention() 
    {
        $string = '
            la Convention de Genève du 28 juillet 1951 relative au statut des réfugiés et le protocole signé à New York le 31 janvier 1967
            La Convention de sauvegarde des droits de l\'homme et des libertés fondamentales, signée à Rome le 4 novembre 1950
        ';

        $v = (new Basic($string))->convention();

        $this->assertEquals($v[0]['id'], 'convention genève 1951');
        $this->assertEquals($v[1]['id'], 'convention rome 1950');
    }
        
    public function testDecisionCadreUe()    
    {
        $string = '
            décision-cadre n° 2002/584/JAI
        ';

        $v = (new Basic($string))->decisionCadreUe();

        $this->assertEquals($v[0]['numero'], '2002/584/JAI');
    }
        
    public function testDecisionCc() 
    {
        $string = '
            n° 2013-4793 AN 
            la décision du Conseil constitutionnel n° 2009-577 DC du 3 mars 2009
        ';

        $v = (new Basic($string))->decisionCc();

        $this->assertEquals($v[0]['numero'], '2013-4793 AN');
        $this->assertEquals($v[1]['numero'], '2009-577 DC');
    }
        
    public function testDeliberationCc() 
    {
        $string = '
            délibération du Conseil constitutionnel en date du 23 octobre 1987 
            délibération du Conseil constitutionnel du 23 octobre 1984 
        ';

        $v = (new Basic($string))->deliberationCc();

        $this->assertEquals($v[0]['date'], '23 octobre 1987');
        $this->assertEquals($v[1]['date'], '23 octobre 1984');
    }
        
    public function testReglementCeOuUe() 
    {
        $string = '
            le règlement (UE) n° 1175/2011 
            le règlement (CE) n° 1466/97 
        ';

        $v = (new Basic($string))->reglementCeOuUe();

        $this->assertEquals($v[0]['numero'], '1175/2011');
        $this->assertEquals($v[0]['institution'], 'UE');
        $this->assertEquals($v[1]['numero'], '1466/97');
        $this->assertEquals($v[1]['institution'], 'CE');
    }
        
    public function testReglementCc() 
    {
        $string = '
            règlement du 4 février 2010 blalabla constitutionnalité 
            règlement du 3 février 2010 blalabla constitutionnalité 
        ';

        $v = (new Basic($string))->reglementCc();

        $this->assertEquals($v[0]['date'], '4 février 2010');
        $this->assertEquals($v[1]['date'], '3 février 2010');
    }
        
    public function testDecisionOuArretCedh()
    {
        $string = '
            l\'arrêt de la Cour européenne des droits de l\'homme n° 4774/98 (affaire Leyla) du 29 juin 2004 
            décision de la Cour européenne des droits de l\'homme du 15 janvier 2009
            Dans sa décision ou dans son arrêt (date ou référence) la Cour européenne des droits de l`\'homme
        ';

        $v = (new Basic($string))->decisionOuArretCedh();

        $this->assertEquals($v[0]['numero'], '4774/98');
        $this->assertEquals($v[1]['date'], '15 janvier 2009');
    }
}
