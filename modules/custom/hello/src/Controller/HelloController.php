<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {
    public function content($param1, $param2) {
        return array (
            '#markup' => $this->t('Hello: %username! Parameter: %param1, %param2',
                array(
                '%username' => $this->currentUser()->getUsername(),
                '%param1' => $param1,
                '%param2' => $param2
                )),
            '#cache' => array(
                'max-age' =>'10'
            )
        );
    }
}
