<?php

namespace eStore\ShopBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class eStoreShopBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
