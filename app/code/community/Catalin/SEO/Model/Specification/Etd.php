<?php

/**
 * Created by PhpStorm.
 * User: martijnharbers
 * Date: 27-10-15
 * Time: 11:23
 */
class Catalin_SEO_Model_Specification_Etd
{
    public function isSatisfiedBy( Mage_Catalog_Block_Layer_Filter_Attribute $attribute )
    {
        return in_array(
            strtolower( $attribute->getName() ),
            array( 'geschatte levertijd', 'beschikbaarheid' )
        );
    }
}