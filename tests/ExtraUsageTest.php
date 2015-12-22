<?php

namespace Younes0\Reglex\Test;

use Younes0\Reglex\Extra;

class ExtraUsageTest extends \PHPUnit_Framework_TestCase
{
    public function testDccVisa()    
    {
        $string1 = 'Vu la Constitution et notamment ses articles 76 et 77 ;';
        $string2 = 'Vu l\'avis du Conseil d\'État en date du 16 juillet 2013, blabla la loi organique susvisée ;';

        $v = (new Extra($string1.PHP_EOL.$string2))->dccVisa();

        $this->assertEquals($v[0]['raw'], $string1);
        $this->assertEquals($v[1]['raw'], $string2);
    }
    
    public function testDccConsiderant()    
    {
        $string1 = '1. Considérant que le blabla ;';
        $string2 = '30. Considérant que blabla ;';

        $v = (new Extra($string1.PHP_EOL.$string2))->dccConsiderant();
        
        $this->assertEquals($v[0]['raw'], $string1);
        $this->assertEquals($v[1]['raw'], $string2);
    }
    
    public function testDccOuCommentaireDccPremierParagraphe()
    {
        $string1 = 'Le Conseil constitutionnel a été saisi le 28 janvier 2015, par le Premier ministre, dans les conditions prévues par le second alinéa de l\'article 37 de la Constitution, d\'une demande tendant à ce qu\'il se prononce sur la nature juridique du nombre « cinq » figurant au troisième alinéa de l\'article L. 758-1 du code de l\'éducation.';

        $stringAll = PHP_EOL.'LE CONSEIL CONSTITUTIONNEL, '.PHP_EOL.$string1;

        $v = (new Extra($stringAll))->dccOuCommentaireDccPremierParagraphe();

        $this->assertEquals($v[0]['raw'], $string1);
        $this->assertEquals(count($v), 1);
    }
    
    public function testDccMembres()    
    {
        $string = 'Délibéré par le Conseil constitutionnel dans sa séance du 23 juillet 2015, où siégeaient : M. Jean-Louis DEBRÉ, Président, Mmes Claire BAZY MALAURIE, Nicole BELLOUBET, MM. Guy CANIVET, Michel CHARASSE, et Mme Nicole MAESTRACCI.';

        $v = (new Extra($string))->dccMembres();

        $this->assertEquals($v[0]['id'], 'Claire BAZY MALAURIE');
        $this->assertEquals($v[1]['id'], 'Guy CANIVET');
        $this->assertEquals($v[2]['id'], 'Jean-Louis DEBRÉ');
        $this->assertEquals($v[3]['id'], 'Michel CHARASSE');
        $this->assertEquals($v[4]['id'], 'Nicole BELLOUBET');
        $this->assertEquals($v[5]['id'], 'Nicole MAESTRACCI');
    }

    public function testRefDocAuteurs()    
    {
        $string = '
M. Christian Eckert, Rapport sur le projet de loi de finances pour 2013, Assemblée nationale, XIVème.
Nicolas Molfessis, Le Conseil constitutionnel et le droit privé, LGDJ, 1997, n° 169.
Voir Claire Neirnick, , « Le mariage homosexuel ou l’arbre qui cache la forêt », Droit de la famille, octobre 2012, p8 .s
Pierre Murat, « La Constitution et le mariage : regard d’un privatiste », Nouveaux Cahiers du Conseil
Nathalie Merley, « La non-consécration par le Conseil constitutionnel de principes fondamentaux reconnus par les lois de la République », RFDA mai-juin 2005, p. 621 et s.
';
        $v = (new Extra($string))->refDocAuteurs();

        $this->assertEquals($v[0]['auteur'], 'Christian Eckert');
        $this->assertEquals($v[1]['auteur'], 'Nicolas Molfessis');
        $this->assertEquals($v[2]['auteur'], 'Claire Neirnick');
        $this->assertEquals($v[3]['auteur'], 'Pierre Murat');
        $this->assertEquals($v[4]['auteur'], 'Nathalie Merley');
    }
}
