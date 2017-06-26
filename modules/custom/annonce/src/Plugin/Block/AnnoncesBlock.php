<?php

namespace Drupal\annonce\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Annonces block.
 *
 * @Block(
 *  id = "annonces_block",
 *  admin_label = @Translation("Annonces Block"),
 *  deriver = "Drupal\annonce\Plugin\Derivative\AnnoncesDeriver"
 * )
 */
class AnnoncesBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $currentUser;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [
      '#theme' => 'image_style',
      '#style_name' => 'thumbnail',
      '#uri' => $this->pluginDefinition['image']
      //'#markup' => $this->pluginDefinition['content'],
    ];

    return $build;
  }
}