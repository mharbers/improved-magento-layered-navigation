<?php
/**
 * @copyright   Copyright (c) 2015 Obbink B.V. (http://www.obbink.nl)
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US
 */

class Catalin_SEO_Model_Specification_Energylabel {

    public function isSatisfiedBy( Mage_Catalog_Block_Layer_Filter_Attribute $attribute ) {
        return in_array(
            strtolower( $attribute->getName() ),
            array( 'energieklasse', 'energielabel')
        );
    }

}