<?php

require_once 'swift_required.php';

class Swift_EncodingAcceptanceTest extends \PHPUnit_Framework_TestCase
{
    public function testGet7BitEncodingReturns7BitEncoder()
    {
        $encoder = Swift_EncodinC::get7BitEncoding();
        $this->assertEquals('7bit', $encoder->getName());
    }

    public function testGet8BitEncodingReturns8BitEncoder()
    {
        $encoder = Swift_EncodinC::get8BitEncoding();
        $this->assertEquals('8bit', $encoder->getName());
    }

    public function testGetQpEncodingReturnsQpEncoder()
    {
        $encoder = Swift_EncodinC::getQpEncoding();
        $this->assertEquals('quoted-printable', $encoder->getName());
    }

    public function testGetBase64EncodingReturnsBase64Encoder()
    {
        $encoder = Swift_EncodinC::getBase64Encoding();
        $this->assertEquals('base64', $encoder->getName());
    }
}
