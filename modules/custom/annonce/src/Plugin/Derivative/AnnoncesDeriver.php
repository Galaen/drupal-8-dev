<?php

namespace Drupal\annonce\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AnnoncesDeriver extends DeriverBase implements ContainerDeriverInterface {

  protected $annonceStorage;

  public function __construct(EntityStorageInterface $annonceStorage) {
    $this->annonceStorage = $annonceStorage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity.manager')->getStorage('annonce')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {

    $annonces = $this->annonceStorage->loadMultiple();//loadByProperties(['type' => 'annonce']);
    //kint($annonces);
    foreach ($annonces as $annonce) {
      $this->derivatives[$annonce->id()] = $base_plugin_definition;
      $this->derivatives[$annonce->id()]['admin_label'] = t('Annonce block: ') . $annonce->label();
      //$this->derivatives[$annonce->id()]['image'] = $annonce->get('field_images')['0']->entity->uri->value;
    }

    return $this->derivatives;
  }
}