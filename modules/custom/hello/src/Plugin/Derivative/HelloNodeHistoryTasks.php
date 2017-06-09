<?php

/**
 * @file
 * Contains \Drupal\example\Plugin\Derivative\HelloNodeHistoryTasks.
 */

namespace Drupal\example\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;

/**
 * Defines dynamic local tasks.
 */
class HelloNodeHistoryTasks extends DeriverBase {

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    // Implement dynamic logic to provide values for the same keys as in example.links.task.yml.
    $this->derivatives['hello.hello.history'] = $base_plugin_definition;
    $this->derivatives['hello.hello.history']['title'] = "I'm a tab";
//    $this->derivatives['example.task_id']['route_name'] = 'example.route';
    return $this->derivatives;
  }

}