<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloAccessController extends ControllerBase {
  public function content() {
    return [
      '#markup' => 'test'
    ];
  }
}
