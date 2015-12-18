<?php

namespace Younes0\Reglex\Test;

use Younes0\Reglex\Base;

class BaseUsageTest extends \PHPUnit_Framework_TestCase
{
    protected $base;

    public function setUp()
    {        
        $this->base = new Base();
    }

    public function testLoi()
    {
        $v = $this->base->loi('
            L. 2111-4; 
            LO. 1-1 du code général de la propriété des personnes publiques; 
            loi organique n° 2-2;
        ');
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
        $v = $this->base->decret('
            le décret n° 86-451 
            décret n° 2006-1231
        ');

        $this->assertEquals($v[0]['numero'], '86-451');
        $this->assertEquals($v[1]['numero'], '2006-1231');
    }
        
    public function testDecretLoi() 
    {
        $v = $this->base->decretLoi('
            décret-loi du 24 mai 1938
        ');

        $this->assertEquals($v[0]['date'], '24 mai 1938');
    }
        
    public function testOrdonnance() 
    {
        $v = $this->base->ordonnance('
            ordonnance n° 58-1067
            ordonnance du 7 novembre 1958
        ');

        $this->assertEquals($v[0]['numero'], '58-1067');
        $this->assertEquals($v[1]['date'], '7 novembre 1958');
    }
        
    public function testAvis() 
    {
        $v = $this->base->avis('
            l\'avis de la Assemblée territoriale de la Polynésie française en date du 25 novembre 1993 
            l\'avis de la Commission nationale de l\'informatique et des libertés 
            avis du Président de l\'Assemblée nationale inséré au Journal officiel de la République française du 16 mars 2007
        ');
// ldd($v);
        $this->assertEquals($v['institution'][0], 'Assemblée territoriale de la Polynésie française');
        $this->assertEquals($v[0]['date'], '25 novembre 1993');
        $this->assertEquals($v['institution'][1], 'Commission nationale de l\'informatique et des libertés');
        $this->assertEquals($v['institution'][2], 'Président de l\'Assemblée nationale');
    }
        
    public function testArrete() 
    {
        $v = $this->base->arrete('
            l\'arrêté du 12 février 2010
            l\'arrêté interministériel n° 1802 du 29 juin 1979
        ');

        $this->assertEquals($v[0]['date'], '12 février 2010');
        $this->assertEquals($v[1]['date'], '29 juin 1979');
        $this->assertEquals($v[1]['numero'], '1802');
        $this->assertEquals($v['type'][1], 'interministériel');
    }

    public function testArretCa() 
    {
        $v = $this->base->arretCa('
            l\'arrêt de la cour d\'appel de Lyon
            l\'arrêt de la cour d\'appel de Lyon, en date du 14 décembre 1994
            l\'arrêt de la cour d\'appel de Saint-Denis-de-la-Réunion, siégeant en matière civile, en date du 14 décembre 1994
        ');

        $this->assertEquals($v['ville'][0], 'Lyon');
        $this->assertEquals($v['ville'][1], 'Lyon');
        $this->assertEquals($v[1]['date'], '14 décembre 1994');
        $this->assertEquals($v['ville'][2], 'Saint-Denis-de-la-Réunion');
        $this->assertEquals($v[2]['date'], '14 décembre 1994');
        $this->assertEquals($v['matiere'][2], 'civile');
    }
        
    public function testJugementTribunal() 
    {
        $v = $this->base->jugementTribunal('
            le jugement du tribunal de grande instance d\'Argentan,
            le jugement du tribunal de commerce, en date du 7 novembre 1995
            le jugement du tribunal de grande instance d\'Argentan, siégeant en matière correctionnelle, en date du 7 novembre 1995
        ');

        $this->assertEquals($v['tribunal'][0], 'grande instance d\'Argentan');
        $this->assertEquals($v['tribunal'][1], 'commerce');
        $this->assertEquals($v[1]['date'], '7 novembre 1995');
        $this->assertEquals($v['tribunal'][0], 'grande instance d\'Argentan');
        $this->assertEquals($v['matiere'][2], 'correctionnelle');
        $this->assertEquals($v[2]['date'], '7 novembre 1995');
    }
        
    public function testArretCourCassation() 
    {
        $v = $this->base->arretCourCassation('
            Vu l\'arrêt de la Cour de cassation en date du 7 décembre 1995
            l\'arrêt de la Cour de cassation (chambre criminelle) du 30 novembre 2005
        ');

        $this->assertEquals($v[0]['date'], '7 décembre 1995');
        $this->assertEquals($v[1]['date'], '30 novembre 2005');
        $this->assertEquals($v[1]['chambre'], 'criminelle');
    }
        
    public function testArretCourJusticeUe() 
    {
        $v = $this->base->arretCourJusticeUe('
            l\'arrêt de la Cour de justice de l\'Union européenne du 30 mai 2013, n° C-168/13 PPU
            arrêt de la Cour de justice de l\'Union européenne n° T-175/04 PPU
        ');

        $this->assertEquals($v[0]['date'], '30 mai 2013');
        $this->assertEquals($v[0]['numero'], 'C-168/13 PPU');
        $this->assertEquals($v[1]['numero'], 'T-175/04 PPU');
    }
        
    public function testCirculaire() 
    {
        $v = $this->base->circulaire('
            la circulaire du ministre de l\'intérieur et de la sécurité publique du 26 janvier 1993 relative à l\'organisation des élections législatives des 21 et 28 mars 1993;
            la circulaire du ministre de l\'intérieur relative à l\'envoi des formulaires de présentation d\'un candidat à l\'élection présidentielle;
        ');

        $this->assertEquals($v['institution'][0], 'ministre de l\'intérieur et de la sécurité publique');
        $this->assertEquals($v[0]['date'], '26 janvier 1993');
        $this->assertEquals($v['institution'][1], 'ministre de l\'intérieur');
    }
        
    public function testDirectiveUe() 
    {
        $v = $this->base->directiveUe('
            la directive 2003/54/CE 
            la directive 23/54/CE 
        ');

        $this->assertEquals($v[0]['numero'], '2003/54/CE');
        $this->assertEquals($v[1]['numero'], '23/54/CE');
    }
    
    public function testDecisionClassiqueCe() 
    {
        $v = $this->base->decisionClassiqueCe('
            la décision du Conseil d\'État n° 222160 du 30 juin 2003
            la décision du Conseil d\'État nos 265582 et 273093 du 13 mars 2006
        ');

        $this->assertEquals($v[0]['numero'], '222160');
        $this->assertEquals($v[0]['date'], '30 juin 2003');
    }
        
    public function testDecisionRenvoiCe() 
    {
        $v = $this->base->decisionRenvoiCe('
            par le Conseil d\'Etat (décision n° 387472 du même jour) 
            par le Conseil d\'Etat Conseil d\'État (décision nos 380743, 380744 et 380745 du 23 juillet 2014) 
        ');

        $this->assertEquals($v[0]['numero'], '387472');
    }
        
    public function testConstitution() 
    {
        $v = $this->base->constitution('
            constitution du 4 octobre 1958 
            constitution de 1958 
            préambule du 27 octobre 1946
        ');

        $this->assertEquals($v['constitution 1958'], 2);
        $this->assertEquals($v['préambule 1946'], 1);
    }

    public function testConvention() 
    {
        $v = $this->base->convention('
            la Convention de Genève du 28 juillet 1951 relative au statut des réfugiés et le protocole signé à New York le 31 janvier 1967
            La Convention de sauvegarde des droits de l\'homme et des libertés fondamentales, signée à Rome le 4 novembre 1950
        ');

        $this->assertEquals($v['convention genève 1951'], 1);
        $this->assertEquals($v['convention rome 1950'], 1);
    }
        
    public function testDecisionCadreUe()    
    {
        $v = $this->base->decisionCadreUe('
            décision-cadre n° 2002/584/JAI
        ');

        $this->assertEquals($v[0]['numero'], '2002/584/JAI');
    }
        
    public function testDecisionCc() 
    {
        $v = $this->base->decisionCc('
            n° 2013-4793 AN 
            la décision du Conseil constitutionnel n° 2009-577 DC du 3 mars 2009
        ');

        $this->assertEquals($v[0]['numero'], '2013-4793 AN');
        $this->assertEquals($v[1]['numero'], '2009-577 DC');
    }
        
    public function testDeliberationCc() 
    {
        $v = $this->base->deliberationCc('
            délibération du Conseil constitutionnel en date du 23 octobre 1987 
            délibération du Conseil constitutionnel du 23 octobre 1984 
        ');

        $this->assertEquals($v[0]['date'], '23 octobre 1987');
        $this->assertEquals($v[1]['date'], '23 octobre 1984');
    }
        
    public function testReglementCeOuUe() 
    {
        $v = $this->base->reglementCeOuUe('
            le règlement (UE) n° 1175/2011 
            le règlement (CE) n° 1466/97 
        ');

        $this->assertEquals($v[0]['numero'], '1175/2011');
        $this->assertEquals($v[0]['institution'], 'UE');
        $this->assertEquals($v[1]['numero'], '1466/97');
        $this->assertEquals($v[1]['institution'], 'CE');
    }
        
    public function testReglementCc() 
    {
        $v = $this->base->reglementCc('
            règlement du 4 février 2010 blalabla constitutionnalité 
            règlement du 3 février 2010 blalabla constitutionnalité 
        ');

        $this->assertEquals($v[0]['date'], '4 février 2010');
        $this->assertEquals($v[1]['date'], '3 février 2010');
    }
        
    public function testDecisionOuArretCedh()
    {
        $v = $this->base->decisionOuArretCedh('
            l\'arrêt de la Cour européenne des droits de l\'homme n° 4774/98 (affaire Leyla) du 29 juin 2004 
            décision de la Cour européenne des droits de l\'homme du 15 janvier 2009
            Dans sa décision ou dans son arrêt (date ou référence) la Cour européenne des droits de l`\'homme
        ');

        $this->assertEquals($v[0]['numero'], '4774/98');
        $this->assertEquals($v[1]['date'], '15 janvier 2009');
    }
}
