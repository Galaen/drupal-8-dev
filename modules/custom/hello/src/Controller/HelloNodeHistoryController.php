<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloNodeHistoryController extends ControllerBase {
    public function content(\Drupal\node\NodeInterface $node) {

      //kint($node);

      $database = \Drupal::database();
//
//      $result = $database->select('hello_node_history', 'h')
//        ->condition('nid', $node->id())
//        ->fields('h', array('uid', 'update_time'))
//        ->execute();
//        //->fetchAll();


      $query = $database->select('hello_node_history', 'h')
        ->fields('h', array('uid', 'update_time'))
        ->condition('nid', $node->id());


      $result = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit('5')->execute();//->fetchAll();

      $dateFormatter = \Drupal::service('date.formatter');

      $rows = [];
      $header = ['User', 'Update time'];

      $userStorage = $this->entityTypeManager()->getStorage('user');

      foreach ($result as $row) {
        $account = $userStorage->load($row->uid);
        //$account = \Drupal\user\Entity\User::load($row->uid);
        $rows[] = [
          $account->toLink(),
          $dateFormatter->format($row->update_time, 'perso')
        ];
      }


      $pager = array('#type' => 'pager');

      $table = array(
        '#theme' => 'table',
        '#rows' => $rows,
        '#header' => $header/*,
        '#cache' => array(
          'max-age' =>'0'
          //'contexts' => ['url'],
          //'tag' => ['node:list']
        )*/
      );

      return array(
        'table' => $table,
        'pager' => $pager
      );
/*
        return array (
            '#markup' => 'test'
        );
*/
    }
}
