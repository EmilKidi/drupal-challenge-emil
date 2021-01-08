<?php

namespace Drupal\property_lister\Helper;

/**
 * Provides sorting helper functions for the property_listing module.
 */
class Sorting {

    const default_ammount_of_properties = 4;

    /**
    * Returns the instance, for later use to be rendered 
    * the way we want to.
    *
    * @return array a sorted list of properties.
    */
    public static function sortData($data, $ammount = self::default_ammount_of_properties) {
        $data = (array) $data;
        $houses = [];

        // Sort by filter
        if (!empty(\Drupal::request()->query->get('from')) && 
            !empty(\Drupal::request()->query->get('to'))) {
            $data = self::sortByField($data, 'price');
        }

        // Paginate result
        $page = (!empty(\Drupal::request()->query->get('page'))) ?
            \Drupal::request()->query->get('page') - 1 : 
            0;

        $offset = ($page > 0) ? $page * $ammount : 0;

        $houses = $data['results'];
        $houses = array_slice($houses, $offset, $ammount);

        return $houses;
    }

    /**
    * Returns the current page from the query.
    *
    * @return $this.
    */
    public static function getPage() {
        return $page = (!empty(\Drupal::request()->query->get('page'))) ? 
            \Drupal::request()->query->get('page') : 
            0;
    }

    /** 
    *  Sort propertys by from and to filter.
    */
    public static function sortByField($data, $field) {
        // not yet implemented.
    }

}