<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloItemListController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

class HelloItemListController extends ControllerBase {
    public function content($param1) {

        $query = $this->entityTypeManager()->getStorage('node')->getQuery();
        if ($param1) {
            $query->condition('type', $param1);
        }
        $nids = $query->pager('10')->execute();
        $nodes = $this->entityTypeManager()->getStorage('node')->loadMultiple($nids);

        $items = array();
        foreach ($nodes as $node) {
            $items[] = $node->toLink();
        }


        $list = array(
            '#theme' => 'item_list',
            '#items' => $items
        );

        $pager = array(
            '#type' => 'pager'
        );

        return array(
            'list' => $list,
            'pager' => $pager
        );
/*
        //kint($query->execute());

        $storage = $this->entityTypeManager()->getStorage('node');
        $ids = \Drupal::entityQuery('node')->execute();
        //$entities = $storage->loadMultiple($ids);
        $entities = $storage->loadByProperties(array('type' => 'page'));
        //kint($entities);

        if ($param1) {

        $fids = \Drupal::entityQuery('node')
        //->condition('type', 'page')
//        ->range(0, 100)
        ->pager('10')
        ->execute();
        $entities = $storage->loadMultiple($fids);
        }
        else {

            $fids = \Drupal::entityQuery('node')
    //        ->range(0, 100)
            ->pager('10')
            ->execute();
            
            $entities = $storage->loadMultiple($fids);

        }

$items = array();
//$url1 = \Drupal\Core\Url::fromRoute('book.admin');
//$admin_link = 

        foreach ($entities as &$node) {
            //kint($node);
            //Url::fromUri('/node/')

            $items[] = $node->toLink();
        
            // $items[] = [
            // '#markup' => Link::fromTextAndUrl($node->getTitle(), $node->toUrl())->toString(), //Url::fromRoute('node.id', ['id' => $node->id()]))->toString(),//\Drupal::l($node->getTitle(), '/node/'.$node->id()),//\Drupal::l(t('Url 1'), $url1),
            // '#wrapper_attributes' => [
            //     'class' => [
            //     'wrapper__links__link',
            //     ],
            // ],
            // ];
        
        }

        $list = array(
            '#theme' => 'item_list',
            '#items' => $items
        );

        $page = array(
            '#type' => 'pager'
        );

        return array(
            'list' => $list,
            'pager' => $pager
        );
*/
        //return $list;
    }
}
