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
        $string = 'L. 2111-4';

        $values = $this->b->loi($string);
ldd($values);
        $this->assertEquals($values['numero'][0], '2111-4');
        
        // ldd($values);
        // $string = 'loi n° 2111-4';
        // $string = 'loi organique du n° 2111-4';
        // $string = 'LO. 2111-4';
        // $string = 'LO. 2111-4 du code général de la propriété des personnes publiques';

        // foreach ($strings as $string) {

        // }
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
