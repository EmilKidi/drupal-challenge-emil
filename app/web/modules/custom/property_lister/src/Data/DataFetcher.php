<?php

namespace Drupal\property_lister\Data;

use Drupal\property_lister\Helper\Sorting;

/**
 * Provides data fetching for the property_listing module.
 */
class DataFetcher {

    const USE_MOCK = true;

    public $data_endpoint;

    public $totalProperties;

    public function __construct(string $data_endpoint) {
        $this->data_endpoint = $data_endpoint;
    }

    /**
    * Returns the data for later use to be rendered 
    * the way we want to.
    *
    * @return $this.
    */
    public function buildResponse() {
        $path = (self::USE_MOCK) ? $this->getMockPath() : $this->getEndpointPath();
        $data = $this->getJSONData($path);
        $this->totalProperties = count($data->results);

        $data->results = Sorting::sortData($data, 4);

        return (array) $data;
    }

    public function toDisplayArray() {
        return (array) $this->data;
    }

    /** 
    *   Get total ammount of properties.
    */
    public function getTotalProperties() {
        return $this->totalProperties;
    }

    /**
    * Get the data from a file/endpoint.
    * @param string $path.
    *
    * @return array
    *   A simple renderable array.
    */
    public function getJSONData(string $path) {
        $data = file_get_contents($path);
        $data = \json_decode($data);
        return $data; 
    }

    /**
    * Returns the real path to the file.
    *
    * @return string the file path.
    */
    public function getMockPath() {
        return sprintf(\Drupal::service('file_system')
            ->realpath(\Drupal::service('module_handler')
            ->getModule('property_lister')->getPath()) . "%s",
            $this->data_endpoint);
    }

    /**
    * Returns the full adress of a data endpoint.
    */
    public function getEndpointPath() {
        // fetching data from external endpoint not implemented.
    }

}