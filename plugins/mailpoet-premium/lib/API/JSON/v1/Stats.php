<?php

namespace MailPoet\Premium\API\JSON\v1;

if (!defined('ABSPATH')) exit;


use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\API\JSON\Error as APIError;
use MailPoet\Config\AccessControl;
use MailPoet\Models\Newsletter;
use MailPoet\Models\ScheduledTask;
use MailPoet\Newsletter\Url as NewsletterUrl;
use MailPoet\Premium\Newsletter\Stats as CampaignStats;
use MailPoet\Premium\Newsletter\Stats\SubscriberEngagement;
use MailPoet\WooCommerce\Helper as WCHelper;
use MailPoet\WP\Functions as WPFunctions;

class Stats extends APIEndpoint {
  public $permissions = [
    'global' => AccessControl::PERMISSION_MANAGE_EMAILS,
  ];

  /** @var WCHelper */
  private $woocommerceHelper;

  /** @var CampaignStats\PurchasedProducts */
  private $purchasedProducts;

  public function __construct(WCHelper $woocommerceHelper, CampaignStats\PurchasedProducts $purchasedProducts) {
    $this->woocommerceHelper = $woocommerceHelper;
    $this->purchasedProducts = $purchasedProducts;
  }

  public function get($data = []) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $newsletter = Newsletter::findOne($id);
    if (!$newsletter instanceof Newsletter) {
      return $this->errorResponse(
        [
          APIError::NOT_FOUND => WPFunctions::get()->__('This newsletter does not exist.', 'mailpoet-premium'),
        ]
      );
    }

    $newsletter->withSegments()
      ->withSendingQueue()
      ->withTotalSent()
      ->withStatistics($this->woocommerceHelper);

    if (!$this->isNewsletterSent($newsletter)) {
      return $this->errorResponse(
        [
          APIError::NOT_FOUND => WPFunctions::get()->__('This newsletter is not sent yet.', 'mailpoet-premium'),
        ]
      );
    }

    $clickedLinks = CampaignStats::getClickedLinks($newsletter);
    $previewUrl = NewsletterUrl::getViewInBrowserUrl($newsletter);

    $newsletter = $newsletter->asArray();
    $newsletter['clicked_links'] = $clickedLinks;
    $newsletter['preview_url'] = $previewUrl;

    return $this->successResponse($newsletter);
  }

  public function listing($data = []) {
    $id = (isset($data['params']['id']) ? (int)$data['params']['id'] : false);
    $newsletter = Newsletter::findOne($id);
    if (!$newsletter instanceof Newsletter) {
      return $this->errorResponse([
        APIError::NOT_FOUND => WPFunctions::get()->__('This newsletter does not exist.', 'mailpoet-premium'),
      ]);
    }

    $newsletter->withSendingQueue();

    if (!$this->isNewsletterSent($newsletter)) {
      return $this->errorResponse(
        [
          APIError::NOT_FOUND => WPFunctions::get()->__('This newsletter is not sent yet.', 'mailpoet-premium'),
        ]
      );
    }

    $listing = new SubscriberEngagement($data);
    $listingData = $listing->get();

    foreach ($listingData['items'] as &$item) {
      $item['subscriber_url'] = WPFunctions::get()->adminUrl(
        'admin.php?page=mailpoet-subscribers#/edit/' . $item['subscriber_id']
      );
    }
    unset($item);

    return $this->successResponse($listingData['items'], [
      'count' => (int)$listingData['count'],
      'filters' => $listingData['filters'],
      'groups' => $listingData['groups'],
    ]);
  }

  public function isNewsletterSent($newsletter) {
    // for statistics purposes, newsletter (except for welcome notifications) is sent
    // when it has a queue record and it's status is not scheduled
    if (!$newsletter->queue) return false;

    if (
      ($newsletter->type === Newsletter::TYPE_WELCOME)
      || ($newsletter->type === Newsletter::TYPE_AUTOMATIC)
    ) return true;

    return $newsletter->queue['status'] !== ScheduledTask::STATUS_SCHEDULED;
  }

  public function getProducts(array $data = []) {
    $id = (isset($data['newsletter_id']) ? (int)$data['newsletter_id'] : false);
    return $this->successResponse($this->purchasedProducts->getStats($id));
  }
}
