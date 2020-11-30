<?php

namespace Drupal\site_info_api_key_ax_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SiteInfoApiKeyController.
 */
class SiteInfoApiKeyController extends ControllerBase {

  /**
   * Getdata.
   *
   * @param $site_api_key
   * @param \Drupal\node\NodeInterface $node
   *
   * @return JsonResponse
   *   Return JsonResponse of the fetched data, else return "access denied".
   */
  public function getData($site_api_key, NodeInterface $node) {
    // Get the Site API Key configuration value
    $site_api_key_saved = \Drupal::config('siteapikey.configuration')->get('siteapikey');

    // Check for node type is 'page' & configuration key exists & it is the same as the one supplied in Site Info page
    if($node->getType() == 'page' && $site_api_key_saved != 'No API Key yet' && $site_api_key_saved == $site_api_key){

      // Return JSON format of node data
      return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
    }

    // Return access denied if any of the set conditions do not match.
    return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
  }

}
