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

    }
        
    public function testDecretLoi() 
    {
    }
        
    public function testOrdonnanCe() 
    {

    }
        
    public function testAvis() 
    {

    }
        
    public function testArrete() 
    {

    }
        
    public function testArretCa() 
    {

    }
        
    public function testJugementTribunal() 
    {

    }
        
    public function testArretCourCassation() 
    {

    }
        
    public function testArretCourJusticeUe() 
    {

    }
        
    public function testCirculaire() 
    {
    }
        
    public function test_convention() 
    {

    }
        
    public function testDirectiveUe() 
    {

    }
        
    public function testDecisionClassiqueCe() 
    {

    }
        
    public function testDecisionRenvoiCe() 
    {

    }
        
    public function testConstitution() 
    {

    }
        
    public function testDecisionCadreUe()    
    {

    }
        
    public function testDecisionCc() 
    {

    }
        
    public function testDeliberationCc() 
    {

    }
        
    public function testReglementCeOuUe() 
    {

    }
        
    public function testReglementCc() 
    {

    }
        
    public function testDecisionOuArretCedh()
    {

    }
}
