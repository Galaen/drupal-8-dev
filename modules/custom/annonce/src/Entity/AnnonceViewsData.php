<?php

namespace Drupal\annonce\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Annonce entities.
 */
class AnnonceViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
/*
    $data['annonce_field_data']['nb_views'] = [
      'title' => $this->t('Number of Views'),
      'help' => $this->t('The help of this field.'),
      'field' => array(
        'id' => 'node_bulk_form',
      ),
    ];
*/
/*
    $data['annonce_field_data']['nb_views'] = [
      'title' => $this->t('Number of Views'),
      'help' => $this->t('The help of this field.'),
      'field' => array(
        'id' => 'field_images',
      ),
    ];
*/

    $data['annonce_views_history'] = [];
    $data['annonce_views_history']['table'] = [];
    $data['annonce_views_history']['table']['group'] = t('Annonce history');
    $data['annonce_views_history']['table']['provider'] = 'annonce';

    $data['annonce_views_history']['table']['base'] = [
      // Identifier (primary) field in this table for Views.
      'field' => 'hid',
      'title' => t('Annonce History'),
      'help' => t('Annonce history contains historical datas and can be related to annonces.'),
      'weight' => -100,
    ];

    $data['annonce_views_history']['nid'] = [
      // Label in the UI.
      'title' => t('Annonce Id'),
      'help' => t('The help'),
      // Identifier (primary) field in this table for Views.
      'field' => ['id' => 'numeric'],
      'sort'  => ['id' => 'standard'],
      'filter'  => ['id' => 'numeric'],
      'argument'  => ['id' => 'numeric'],
      'relationship' => [
        'base' => 'annonce_filed_data',
        'base field' => 'id',
        // ID of relationship handler plugin to use.
        'id' => 'standard',
        'label' => t('Annonce history NID -> Annonce ID'),
      ],
    ];


    $data['annonce_views_history']['views'] = [
      // Label in the UI.
      'title' => t('Annonce Views'),
      'help' => t('The number of views for this annonce'),
      // Identifier (primary) field in this table for Views.
      'field' => ['id' => 'numeric'],
      'sort'  => ['id' => 'standard'],
      'filter'  => ['id' => 'numeric'],
//      'weight' => -10
//      'relationship' => [
//          // Table you want to join to. (custom user field)
//          'base' => 'annonce_filed_data',
//          // Column you want to Join to. aka field
//          'base field' => 'id',
//          'id' => 'standard',
//          'label' => t('Some thing funny here.'),
//        ],
      ];

/*
    $data['annonce_views_history']['nb_views'] = [
      'title' => $this->t('Number of Views'),
      'help' => $this->t('The help of this field.'),
      'field' => array(
        'id' => 'nid',
      ),
    ];


    $data['node_field_revision']['nid']['relationship']['id'] = 'standard';
    $data['node_field_revision']['nid']['relationship']['base'] = 'node_field_data';
    $data['node_field_revision']['nid']['relationship']['base field'] = 'nid';
    $data['node_field_revision']['nid']['relationship']['title'] = $this->t('Content');
    $data['node_field_revision']['nid']['relationship']['label'] = $this->t('Get the actual content from a content revision.');
*/

    //kint($data);
    //exit();

    //$data['block_content']['id']['field']['id'] = 'block_content';

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
