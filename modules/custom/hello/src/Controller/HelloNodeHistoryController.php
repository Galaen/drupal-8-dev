<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

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

      $count = $query
        ->countQuery()
        ->execute()
        ->fetchField();

      $result = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit('5')->execute();//->fetchAll();

      $dateFormatter = \Drupal::service('date.formatter');

      $rows = [];
      $header = ['User', 'Update time'];

      $userStorage = $this->entityTypeManager()->getStorage('user');


//      $count = 0;
      foreach ($result as $row) {
        $account = $userStorage->load($row->uid);
        //$account = \Drupal\user\Entity\User::load($row->uid);
        $rows[] = [
          $account->toLink(),
          $dateFormatter->format($row->update_time, 'perso')
        ];
 //       $count++;
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

      $link['examples_link'] = [
        '#title' => $this->t('Click me for a surprise!!!'),
        '#type' => 'link',
        '#url' => Url::fromRoute('hello.path_with_data'), //Url::fromRoute('examples.description'),
        '#prefix' => '<div id="foo-replace">',
        '#suffix' => '</div>',
        //'#id' => 'foo-replace',
        '#ajax' => [
          //'event' => 'click',
          //'method' => 'replaceWith',
          //'wrapper' => 'foo-replace',
          'effect' => 'fade'
        ]
      ];

      return [
        'link' => $link,
        'hello_node_history' => [
          '#theme' => 'hello_node_history',
          '#node' => $node,//->getTitle(),
          '#count' => $count
        ],
        'table' => $table,
        'pager' => $pager
      ];
/*
        return array (
            '#markup' => 'test'
        );
*/
    }
}
