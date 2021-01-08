<?php
namespace Drupal\property_lister\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\property_lister\Data\DataFetcher;
use Drupal\block\Entity\Block;

/**
 * Provides route responses for the property_listing module.
 */
class ListingController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function render() {
    $dataFetcher = new DataFetcher('/src/mock/response.json');
    \Drupal::service('page_cache_kill_switch')->trigger();

    return [
        '#theme' => 'listings',
        '#data' => $dataFetcher->buildResponse(),
        '#totalProperties' => $dataFetcher->getTotalProperties(),
        '#attached' => [
            'library' => [
                'property_lister/lister',
            ],
        ],
    ];
  }

}