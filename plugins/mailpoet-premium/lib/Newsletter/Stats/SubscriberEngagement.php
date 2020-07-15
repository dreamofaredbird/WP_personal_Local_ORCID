<?php

namespace MailPoet\Premium\Newsletter\Stats;

if (!defined('ABSPATH')) exit;


use MailPoet\Listing\PageLimit;
use MailPoet\Models\NewsletterLink;
use MailPoet\Models\StatisticsClicks;
use MailPoet\Models\StatisticsNewsletters;
use MailPoet\Models\StatisticsOpens;
use MailPoet\Models\StatisticsUnsubscribes;
use MailPoet\Models\Subscriber;
use MailPoet\WP\Functions as WPFunctions;

use function MailPoetVendor\array_column;

class SubscriberEngagement {
  const STATUS_OPENED = 'opened';
  const STATUS_CLICKED = 'clicked';
  const STATUS_UNSUBSCRIBED = 'unsubscribed';
  const STATUS_UNOPENED = 'unopened';

  private $group;
  private $filters;
  private $search;
  private $sortBy;
  private $sortOrder;
  private $offset;
  private $limit;
  private $newsletterId;

  public function __construct($data = []) {
    // check if sort order was specified or default to "desc"
    $sortOrder = (!empty($data['sort_order'])) ? $data['sort_order'] : 'desc';
    // constrain sort order value to either be "asc" or "desc"
    $sortOrder = ($sortOrder === 'asc') ? 'asc' : 'desc';

    // sanitize sort by
    $sortableColumns = ['email', 'status', 'created_at'];
    $sortBy = (!empty($data['sort_by']) && in_array($data['sort_by'], $sortableColumns))
      ? $data['sort_by']
      : '';

    if (empty($sortBy)) {
      $sortBy = 'created_at';
    }

    $this->group = (isset($data['group']) ? $data['group'] : null);
    $this->filters = (isset($data['filter']) ? $data['filter'] : null);
    $this->search = (isset($data['search']) ? $data['search'] : null);
    $this->sortBy = $sortBy;
    $this->sortOrder = $sortOrder;
    $this->offset = (isset($data['offset']) ? (int)$data['offset'] : 0);
    $this->limit = (isset($data['limit']) ? (int)$data['limit'] : PageLimit::DEFAULT_LIMIT_PER_PAGE);
    $this->newsletterId = (isset($data['params']['id']) ? (int)$data['params']['id'] : null);
  }

  public function get() {
    $countQuery = $this->getStatsQuery(true);
    if (empty($countQuery)) {
      return $this->emptyResponse();
    }

    $count = Subscriber::rawQuery(
      ' SELECT COUNT(*) as cnt FROM ( ' . $countQuery . ' ) t '
    )->findArray();
    $count = $count[0]['cnt'];

    $statsQuery = $this->getStatsQuery();
    $items = Subscriber::rawQuery(
      $statsQuery . ' ORDER BY ' . $this->sortBy . ' ' . $this->sortOrder . ' LIMIT ' . $this->limit . ' OFFSET ' . $this->offset
    )->findArray();

    return [
      'count' => $count,
      'filters' => $this->filters(),
      'groups' => $this->groups(),
      'items' => $items,
    ];
  }

  private function getStatsQuery($count = false, $group = null, $applyConstraints = true) {
    $filterConstraint = '';
    $searchConstraint = '';

    if ($applyConstraints) {
      $filterConstraint = $this->getFilterConstraint();
      $searchConstraint = $this->getSearchConstraint();
      if (($searchConstraint) === false) {
        // Nothing was found by search
        return false;
      }
    }

    $queries = [];

    $fields = [
      'opens.id',
      'opens.subscriber_id',
      '"' . self::STATUS_OPENED . '" as status',
      'opens.created_at',
      'subscribers.email',
      'subscribers.first_name',
      'subscribers.last_name',
    ];

    $queries[self::STATUS_OPENED] = '(SELECT '
      . self::getColumnList($fields, $count) . ' '
      . 'FROM ' . StatisticsOpens::$_table . ' opens '
      . 'LEFT JOIN ' . Subscriber::$_table . ' subscribers ON subscribers.id = opens.subscriber_id '
      . 'WHERE opens.newsletter_id = "' . $this->newsletterId . '" ' . $searchConstraint . ') ';

    $fields = [
      'clicks.id',
      'clicks.subscriber_id',
      '"' . self::STATUS_CLICKED . '" as status',
      'clicks.created_at',
      'subscribers.email',
      'subscribers.first_name',
      'subscribers.last_name',
    ];

    $queries[self::STATUS_CLICKED] = '(SELECT '
      . self::getColumnList($fields, $count) . ' '
      . 'FROM ' . StatisticsClicks::$_table . ' clicks '
      . 'LEFT JOIN ' . Subscriber::$_table . ' subscribers ON subscribers.id = clicks.subscriber_id '
      . 'WHERE clicks.newsletter_id = "' . $this->newsletterId . '" ' . $searchConstraint . $filterConstraint . ') ';

    $fields = [
      'unsubscribes.id',
      'unsubscribes.subscriber_id',
      '"' . self::STATUS_UNSUBSCRIBED . '" as status',
      'unsubscribes.created_at',
      'subscribers.email',
      'subscribers.first_name',
      'subscribers.last_name',
    ];

    $queries[self::STATUS_UNSUBSCRIBED] = '(SELECT '
      . self::getColumnList($fields, $count) . ' '
      . 'FROM ' . StatisticsUnsubscribes::$_table . ' unsubscribes '
      . 'LEFT JOIN ' . Subscriber::$_table . ' subscribers ON subscribers.id = unsubscribes.subscriber_id '
      . 'WHERE unsubscribes.newsletter_id = "' . $this->newsletterId . '" ' . $searchConstraint . ') ';

    $fields = [
      'sent.id',
      'sent.subscriber_id',
      '"' . self::STATUS_UNOPENED . '" as status',
      'sent.sent_at as created_at',
      'subscribers.email',
      'subscribers.first_name',
      'subscribers.last_name',
    ];

    $queries[self::STATUS_UNOPENED] = '(SELECT '
      . self::getColumnList($fields, $count) . ' '
      . 'FROM ' . StatisticsNewsletters::$_table . ' sent '
      . 'LEFT JOIN ' . Subscriber::$_table . ' subscribers ON subscribers.id = sent.subscriber_id '
      . 'LEFT JOIN ' . StatisticsOpens::$_table . ' opens ON sent.subscriber_id = opens.subscriber_id '
      . ' AND opens.newsletter_id = sent.newsletter_id ' . 'WHERE sent.newsletter_id = "' . $this->newsletterId . '" '
      . ' AND opens.id IS NULL ' . $searchConstraint . ') ';

    $group = $group ?: $this->group;

    if (isset($queries[$group])) {
      $statsQuery = $queries[$group];
    } else {
      $statsQuery = join(
        ' UNION ALL ',
        [
          $queries[self::STATUS_OPENED],
          $queries[self::STATUS_CLICKED],
          $queries[self::STATUS_UNSUBSCRIBED],
        ]
      );
    }

    return $statsQuery;
  }

  private function getFilterConstraint() {
    // Filter by link clicked
    $linkConstraint = '';
    if (!empty($this->filters['link'])) {
      $link = NewsletterLink::findOne((int)$this->filters['link']);
      if ($link instanceof NewsletterLink) {
        $this->group = self::STATUS_CLICKED;
        $linkConstraint = ' AND clicks.link_id = "' . $link->id . '"';
      }
    }

    return $linkConstraint;
  }

  private function getSearchConstraint() {
    // Search recipients
    $subscriberIds = [];
    if (!empty($this->search)) {
      $subscriberIds = Subscriber::select('id')->filter('search', $this->search)->findArray();
      $subscriberIds = array_column($subscriberIds, 'id');
      if (empty($subscriberIds)) {
        return false;
      }
    }
    $subscribersConstraint = '';
    if (!empty($subscriberIds)) {
      $subscribersConstraint = sprintf(
        ' AND subscribers.id IN (%s) ',
        join(',', array_map('intval', $subscriberIds))
      );
    }

    return $subscribersConstraint;
  }

  public static function getColumnList(array $fields, $count = false) {
    // Select ID field only for counting
    return $count ? reset($fields) : join(', ', $fields);
  }

  public function filters() {
    $links = StatisticsClicks::tableAlias('clicks')
      ->selectExpr(
        'clicks.link_id, links.url, COUNT(DISTINCT clicks.subscriber_id) as cnt'
      )
      ->join(
        MP_NEWSLETTER_LINKS_TABLE,
        'links.id = clicks.link_id',
        'links'
      )
      ->where('newsletter_id', $this->newsletterId)
      ->groupBy('clicks.link_id')
      ->orderByAsc('links.url')
      ->findArray();


    $linkList = [];
    $linkList[] = [
      'label' => WPFunctions::get()->__('Filter by link clicked', 'mailpoet-premium'),
      'value' => '',
    ];

    foreach ($links as $link) {
      $label = sprintf(
        '%s (%s)',
        $link['url'],
        number_format($link['cnt'])
      );

      $linkList[] = [
        'label' => $label,
        'value' => $link['link_id'],
      ];
    }

    $filters = [
      'link' => $linkList,
    ];

    return $filters;
  }

  public function groups() {
    $newsletterId = $this->newsletterId;

    $groups = [
      [
        'name' => self::STATUS_CLICKED,
        'label' => WPFunctions::get()->_x('Clicked', 'Subscriber engagement filter - filter those who clicked on a newsletter link', 'mailpoet-premium'),
        'count' => StatisticsClicks::where('newsletter_id', $newsletterId)->count(),
      ],
      [
        'name' => self::STATUS_OPENED,
        'label' => WPFunctions::get()->_x('Opened', 'Subscriber engagement filter - filter those who opened a newsletter', 'mailpoet-premium'),
        'count' => StatisticsOpens::where('newsletter_id', $newsletterId)->count(),
      ],
      [
        'name' => self::STATUS_UNSUBSCRIBED,
        'label' => WPFunctions::get()->_x('Unsubscribed', 'Subscriber engagement filter - filter those who unsubscribed from a newsletter', 'mailpoet-premium'),
        'count' => StatisticsUnsubscribes::where('newsletter_id', $newsletterId)->count(),
      ],
    ];

    array_unshift(
      $groups,
      [
        'name' => 'all',
        'label' => WPFunctions::get()->_x('All engaged', 'Subscriber engagement filter - filter those who performed any action (e.g., clicked, opened, unsubscribed)', 'mailpoet-premium'),
        'count' => array_sum(array_column($groups, 'count')),
      ]
    );

    $unopenedCount = Subscriber::rawQuery(
      ' SELECT COUNT(*) as cnt FROM ( ' . $this->getStatsQuery(true, self::STATUS_UNOPENED, false) . ' ) t '
    )->findArray();
    $unopenedCount = (int)$unopenedCount[0]['cnt'];

    $groups[] = [
      'name' => self::STATUS_UNOPENED,
      'label' => WPFunctions::get()->_x('Unopened', 'Subscriber engagement filter - filter those who did not open a newsletter', 'mailpoet-premium'),
      'count' => $unopenedCount,
    ];

    return $groups;
  }

  public function emptyResponse() {
    return [
      'count' => 0,
      'filters' => $this->filters(),
      'groups' => $this->groups(),
      'items' => [],
    ];
  }
}
