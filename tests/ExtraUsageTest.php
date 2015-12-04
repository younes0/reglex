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
        $string2 = '21. Considérant que blabla ;';

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
        $v = $this->extra->testdccMembres($string1);
    }
}
