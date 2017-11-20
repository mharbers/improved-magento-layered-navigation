<?php

/**
 * Catalin Ciobanu
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License (MIT)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @package     Catalin_Seo
 * @copyright   Copyright (c) 2016 Catalin Ciobanu
 * @license     https://opensource.org/licenses/MIT  MIT License (MIT)
 */
class Catalin_SEO_Block_Catalog_Layer_Filter_Attribute extends Mage_Catalog_Block_Layer_Filter_Attribute
{

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->helper('catalin_seo')->isEnabled()
            && $this->helper('catalin_seo')->isMultipleChoiceFiltersEnabled()) {
            /**
             * Modify template for multiple filters rendering
             * It has checkboxes instead of classic links
             */
            $this->setTemplate('catalin_seo/catalog/layer/filter.phtml');
        }
    }

    /**
     * @return string
     */
    public function getHtml() {
        $this->_setFilterTemplate( $this );

        return parent::getHtml();
    }

    public function getClearUrl() {

        if ($this->helper('catalin_seo')->isCatalogSearch()) {
            $filterState = array('isLayerAjax' => null);
            foreach ($this->getActiveFilters() as $item) {
                $filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
            }
            $params['_current'] = true;
            $params['_use_rewrite'] = true;
            $params['_query'] = $filterState;
            $params['_escape'] = true;
            return Mage::getUrl('*/*/*', $params);
        }

        return $this->helper('catalin_seo')->getClearFiltersUrl();
    }

    /**
     * @return array
     */
    public function getItems() {
        $spec   = Mage::getModel( 'catalin_seo/specification_energylabel' );
        if( $spec && $spec->isSatisfiedBy( $this ) ) {
            $sorted = array();
            $items = parent::getItems();
            foreach ($items as $_item)
            {
                $sorted[sprintf( "%'A5s", $_item->getLabel() )]    = $_item;
            }
            ksort( $sorted );
            foreach( $sorted as $_item )
            {
                $sorted[$_item->getLabel()] = $_item;
            }
            return $sorted;
        }

        return parent::getItems();
    }

    public function getSelectedFirstItems()
    {
        $items = $this->getItems();
        $selected = [];
        $notSelected = [];

        foreach ($items as $item) {
            if ($item->isSelected()) {
                $selected[$item->getLabel()] = $item;
                continue;
            }
            $notSelected[$item->getLabel()] = $item;
        }

        ksort($selected);
        ksort($notSelected);

        return array_merge(
            $selected,
            $notSelected
        );
    }

    /**
     * @return array
     */
    public function getEnergylabelRange() {
        foreach( $this->getItems() as $item ) {
            if( in_array( $item->getLabel(), array( 'A+++', 'A++', 'A+' ) ) ) {
                return array( 'A+++', 'A++', 'A+', 'A', 'B', 'C', 'D' );
            }
        }

        return array( 'A', 'B', 'C', 'D', 'E', 'F' );
    }

    protected function _setFilterTemplate( Mage_Catalog_Block_Layer_Filter_Attribute $attribute )
    {
        $energySpec   = Mage::getModel( 'catalin_seo/specification_energylabel' );
        if( $energySpec && $energySpec->isSatisfiedBy( $attribute ) ) {
            $this->setTemplate('catalin_seo/catalog/layer/filter_energylabel.phtml');
        } else {
            $etdSpec    = Mage::getModel( 'catalin_seo/specification_etd' );
            if( $etdSpec && $etdSpec->isSatisfiedBy( $attribute ) ) {
                $this->setTemplate( 'catalin_seo/catalog/layer/filter_etd.phtml' );
            }
        }
    }

}
