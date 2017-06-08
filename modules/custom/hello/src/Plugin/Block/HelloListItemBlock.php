<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
//use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

use Drupal\Core\Entity\EntityTypeManagerInterface;
//use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_list_item_block",
 *  admin_label = @Translation("List Item")
 * )
 */
class HelloListItemBlock extends BlockBase implements ContainerFactoryPluginInterface {

    protected $currentUser;
    protected $connection;
    protected $entityTypeManager;
    protected $entityQuery;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser, Connection $database, EntityTypeManagerInterface $entityTypeManager, QueryFactory $entityQuery) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->currentUser = $current_user;
        $this->connection = $database;
        $this->entityTypeManager = $entityTypeManager;
        $this->entityQuery = $entityQuery;
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
      $container->get('database'),
      $container->get('entity_type.manager'),
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $type = null;
    $current_path = \Drupal::service('path.current')->getPath();
    //$current_path = \Drupal::service('current_route_match')->getPath();   // <= mieux
    // if (is_a($current_node, 'Drupal\node\Entity\Node')) $current

    $params = \Drupal\Core\Url::fromUserInput($current_path)->getRouteParameters();
    if (isset($params['node'])) {
        $node = \Drupal\node\Entity\Node::load($params['node']);
        $type = $node->getType();
    }

    //$storage = \Drupal::entityTypeManager()->getStorage('node');
    $storage = $this->entityTypeManager->getStorage('node');

    if($type) {
        $ids = $this->entityQuery->get('node') //$this->entityQuery('node')   //\Drupal::entityQuery('node')
            ->condition('type', $type)
            ->sort('created', 'desc')
            ->range(0, 3)
            ->execute();
    }
    else {
        $ids = $this->entityQuery->get('node') //$this->entityQuery('node')   //\Drupal::entityQuery('node')
            ->sort('created', 'desc')
            ->range(0, 3)
            ->execute();        
    }
    $entities = $storage->loadMultiple($ids);


    foreach ($entities as &$node) {
        $items[] = $node->toLink();
    }

    return array(
        '#theme' => 'item_list',
        '#items' => $items,
        '#cache' => array(
            'max-age' =>'0'
        )
    );
  }

}