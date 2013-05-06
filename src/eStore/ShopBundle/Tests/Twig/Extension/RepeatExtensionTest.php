<?php

namespace eStore\ShopBundle\Tests\Twig\Extension;

use eStore\ShopBundle\Twig\Extension\RepeatExtension;

class RepeatExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testRepeat()
    {
        $ext = new RepeatExtension();

        $this->assertEquals('', $ext->repeat('a', 0) );
        $this->assertEquals('aaa', $ext->repeat('a', 3) );
        
        $this->setExpectedException('\eStore\ShopBundle\Exception\LessThanZeroException');
        $this->assertEquals('', $ext->repeat('a', -1));
    }
}
