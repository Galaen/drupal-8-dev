<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloNodeHistoryController extends ControllerBase {
    public function content($node) {

      $database = \Drupal::database();

      $result = $database->select('hello_node_history', 'h')
        ->condition('nid', $node)
        ->fields('h', array('uid', 'update_time'))
        ->execute()
        ->fetchAll();

      $dateFormatter = \Drupal::service('date.formatter');

      $rows = [];
      $header = ['User', 'Update time'];

      foreach ($result as &$row) {
        $account = \Drupal\user\Entity\User::load($row->uid);
        $rows[] = [
          $account->toLink(),
          $dateFormatter->format($row->update_time, 'perso')
        ];
      }

/*
      $rows = array(
        // Simple row
        array(
          'Cell 1', 'Cell 2', 'Cell 3'
        ),
        // Row with attributes on the row and some of its cells.
        array(
          'data' => array('Cell 1', array('data' => 'Cell 2', 'colspan' => 2)), 'class' => array('funky')
        ),
      );
*/
      return array(
        '#theme' => 'table',
        '#rows' => $rows,
        '#header' => $header,
        '#cache' => array(
                    'max-age' =>'0'
        //'contexts' => ['url'],
        //'tag' => ['node:list']
      )
    );
/*
        return array (
            '#markup' => 'test'
        );
*/
    }
}
