<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
//use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Plugin\views\filter\Access;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_active_session_block",
 *  admin_label = @Translation("Active Sessions")
 * )
 */
class HelloActiveSessionBlock extends BlockBase implements ContainerFactoryPluginInterface {

    protected $currentUser;
    protected $connection;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $currentUser, Connection $database) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->currentUser = $currentUser;
        $this->connection = $database;
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
      $container->get('database')
    );
  }

  protected function blockAccess(AccountInterface $account) {
    if ($account->hasPermission('hello.access'))
      return AccessResult::allowed();
    else
      return AccessResult::forbidden();
//    if ()
//      return AccessResult::allowed();
//    else
      //return AccessResult::forbiddenIf($account->hasPermission('hello.access'));

//    return parent::blockAccess($account); // TODO: Change the autogenerated stub
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // $build = array(
    //     '#markup' => $this->t('Bienvenue sur notre site. Il est %time !!', array(
    //         "%time" => $this->dateFormatter->format(time(), 'perso'))),
    //         '#cache' => array(
    //             'keys' => ['hello_block'],
    //             'max-age' =>'10'
    //         )
    // );

    // $build = array(
    //     '#markup' => 'test'
    // );


    $result = $this->connection->select('sessions', 's')
        //->fields('s', array('uid'))
        ->countQuery()
        ->execute()
        ->fetchField();

    $build = array(
        '#markup' => $this->t('Il y a actuellement %sessions session(s) active(s).', array(
            "%sessions" => $result)),
            '#cache' => array(
                'keys' => ['hello_session_block'],
                'max-age' =>'0'
            )
    );

    return $build;
  }

}