<?php

namespace MailPoet\Form\Block;

if (!defined('ABSPATH')) exit;


class Divider {

  public function render(): string {
    return '<hr class="mailpoet_divider" />';
  }
}
