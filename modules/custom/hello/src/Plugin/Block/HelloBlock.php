<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\DateTime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
//use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_block",
 *  admin_label = @Translation("Hello!")
 * )
 */
class HelloBlock extends BlockBase implements ContainerFactoryPluginInterface {

//    var $currentUser;
//    var $dateFormatter;
    protected $currentUser;
    protected $dateFormatter;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser, DateFormatterInterface $dateFormatter) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->currentUser = $current_user;
        $this->dateFormatter = $dateFormatter;
    }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = array(
        '#markup' => $this->t('Bienvenue sur notre site. Il est %time !!', array(
            "%time" => $this->dateFormatter->format(time(), 'perso'))),
            '#cache' => array(
                'keys' => ['hello_block'],
                'max-age' =>'10'
            )
    );

    return $build;
  }


    /**
     * Implements Drupal\Core\Block\BlockBase::build()
     */
     /*
    public function build() {
        //$account = \Drupal::currentUser();
        $formatter = \Drupal::service('date.formatter');
        $build = array('#markup' => $this->t('Bienvenue sur notre site. Il est %time', array(
            "%time" => $formatter->format(time(), 'short')
        )));

        return $build;
    }*/
}