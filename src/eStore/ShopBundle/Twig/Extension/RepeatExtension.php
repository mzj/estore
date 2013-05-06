<?php

namespace eStore\ShopBundle\Twig\Extension;

use eStore\ShopBundle\Exception\LessThanZeroException;

class RepeatExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'repeat' => new \Twig_Filter_Method($this, 'repeat'),
        );
    }

    public function repeat($str, $times)
    {
        if($times < 0) {
            throw new LessThanZeroException();
        }
        return str_repeat($str, $times);
    }

    public function getName()
    {
        return 'repeat_extension';
    }
}
