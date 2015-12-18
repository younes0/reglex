<?php

namespace Younes0\Reglex\Test;

use Younes0\Reglex\Base;
use Younes0\Reglex\Extra;

class ExtraUsageTest extends \PHPUnit_Framework_TestCase
{
    protected $base;

    protected $extra;

    public function setUp()
    {        
        $this->base  = new Base();
        $this->extra = new Extra();
    }

    public function testDccVisa()    
    {
        $string1 = 'Vu la Constitution et notamment ses articles 76 et 77 ;';
        $string2 = 'Vu l\'avis du Conseil d\'État en date du 16 juillet 2013, blabla la loi organique susvisée ;';

        $v = $this->extra->dccVisa($string1.PHP_EOL.$string2);

        $this->assertEquals($v[0], $string1);
        $this->assertEquals($v[1], $string2);
    }
    
    public function testDccConsiderant()    
    {
        $string1 = '1. Considérant que le blabla ;';
        $string2 = '30. Considérant que blabla ;';

        $v = $this->extra->dccConsiderant($string1.PHP_EOL.$string2);

        $this->assertEquals($v[0], $string1);
        $this->assertEquals($v[1], $string2);
    }
    
    public function testDccOuCommentaireDccPremierParagraphe()
    {
        $string1 = 'Le Conseil constitutionnel a été saisi le 28 janvier 2015, par le Premier ministre, dans les conditions prévues par le second alinéa de l\'article 37 de la Constitution, d\'une demande tendant à ce qu\'il se prononce sur la nature juridique du nombre « cinq » figurant au troisième alinéa de l\'article L. 758-1 du code de l\'éducation.';

        $string2 = PHP_EOL.'LE CONSEIL CONSTITUTIONNEL, '.PHP_EOL.$string1;

        $v = $this->extra->dccOuCommentaireDccPremierParagraphe($string1.$string2);

        $this->assertEquals($v[0], $string1);
        $this->assertEquals(count($v), 1);
    }
    
    public function testDccMembres()    
    {
        $v = $this->extra->dccMembres('Délibéré par le Conseil constitutionnel dans sa séance du 23 juillet 2015, où siégeaient : M. Jean-Louis DEBRÉ, Président, Mmes Claire BAZY MALAURIE, Nicole BELLOUBET, MM. Guy CANIVET, Michel CHARASSE, et Mme Nicole MAESTRACCI.');

        $this->assertEquals($v, [
            "Claire BAZY MALAURIE",
            "Guy CANIVET",
            "Jean-Louis DEBRÉ",
            "Michel CHARASSE",
            "Nicole BELLOUBET",
            "Nicole MAESTRACCI",
        ]);
    }

    public function testRefDocAuteurs()    
    {
        $v = $this->extra->refDocAuteurs('
M. Christian Eckert, Rapport sur le projet de loi de finances pour 2013, Assemblée nationale, XIVème.
Nicolas Molfessis, Le Conseil constitutionnel et le droit privé, LGDJ, 1997, n° 169.
Voir Claire Neirnick, , « Le mariage homosexuel ou l’arbre qui cache la forêt », Droit de la famille, octobre 2012, p8 .s
Pierre Murat, « La Constitution et le mariage : regard d’un privatiste », Nouveaux Cahiers du Conseil
Nathalie Merley, « La non-consécration par le Conseil constitutionnel de principes fondamentaux reconnus par les lois de la République », RFDA mai-juin 2005, p. 621 et s.
');

        $this->assertEquals($v[0]['auteur'], 'Christian Eckert');
        $this->assertEquals($v[1]['auteur'], 'Nicolas Molfessis');
        $this->assertEquals($v[2]['auteur'], 'Claire Neirnick');
        $this->assertEquals($v[3]['auteur'], 'Pierre Murat');
        $this->assertEquals($v[4]['auteur'], 'Nathalie Merley');
    }
}
