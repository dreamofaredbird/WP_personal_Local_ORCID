<?php

namespace MailPoet\Subscribers\ImportExport\Export;

if (!defined('ABSPATH')) exit;


use MailPoet\Models\Segment;
use MailPoet\Models\Subscriber;
use MailPoet\Models\SubscriberSegment;
use MailPoet\WP\Functions as WPFunctions;

/**
 * Gets batches of subscribers from default segments.
 */

class DefaultSubscribersGetter extends SubscribersGetter {

  /**
   * @var bool
   */
  protected $getSubscribersWithoutSegment;

  public function __construct($segmentsIds, $batchSize) {
    parent::__construct($segmentsIds, $batchSize);
    $this->getSubscribersWithoutSegment = (array_search(0, $segmentsIds) !== false);
  }

  protected function filter($subscribers) {
    $subscribers = $subscribers
      ->selectMany(
        [
          'list_status' => SubscriberSegment::$_table . '.status',
        ]
      )
      ->left_outer_join(
        SubscriberSegment::$_table,
        [
          Subscriber::$_table . '.id',
          '=',
          SubscriberSegment::$_table . '.subscriber_id',
        ]
      )
      ->left_outer_join(
        Segment::$_table,
        [
          Segment::$_table . '.id',
          '=',
          SubscriberSegment::$_table . '.segment_id',
        ]
      )
      ->groupBy(Segment::$_table . '.id');

    if ($this->getSubscribersWithoutSegment !== false) {
      // if there are subscribers who do not belong to any segment, use
      // a CASE function to group them under "Not In Segment"
      $subscribers = $subscribers
        ->selectExpr(
          'MAX(CASE WHEN ' . Segment::$_table . '.name IS NOT NULL ' .
          'THEN ' . Segment::$_table . '.name ' .
          'ELSE "' . WPFunctions::get()->__('Not In Segment', 'mailpoet') . '" END) as segment_name'
        )
        ->whereRaw(
          SubscriberSegment::$_table . '.segment_id IN (' .
          rtrim(str_repeat('?,', count($this->segmentsIds)), ',') . ') ' .
          'OR ' . SubscriberSegment::$_table . '.segment_id IS NULL ',
          $this->segmentsIds
        );
    } else {
      // if all subscribers belong to at least one segment, select the segment name
      $subscribers = $subscribers
        ->selectExpr('MAX(' . Segment::$_table . '.name) as segment_name')
        ->whereIn(SubscriberSegment::$_table . '.segment_id', $this->segmentsIds);
    }

    $subscribers = $subscribers
      ->offset($this->offset)
      ->limit($this->batchSize)
      ->findArray();

    return $subscribers;
  }

}
