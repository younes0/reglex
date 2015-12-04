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
        $str1 = 'Vu la Constitution et notamment ses articles 76 et 77 ;';
        $str2 = 'Vu l\'avis du Conseil d\'État en date du 16 juillet 2013, blabla la loi organique susvisée ;';

        $v = $this->extra->dccVisa($str1.PHP_EOL.$str2);

        $this->assertEquals($v[0], $str1);
        $this->assertEquals($v[1], $str2);
    }
    
    public function testDccConsiderant()    
    {
        $str1 = '1. Considérant que le blabla ;';
        $str2 = '21. Considérant que blabla ;';

        $v = $this->extra->dccConsiderant($str1.PHP_EOL.$str2);

        $this->assertEquals($v[0], $str1);
        $this->assertEquals($v[1], $str2);
    }
    
    public function testdccOuCommentaireDccPremierParagraphe()
    {

    }
    
    // public function testdccMembres()    
    // {

    // }
}
