<?php

namespace Drupal\annonce\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\HttpKernel;
use Drupal\Core\Database\Connection;


/**
 * Class AnnonceEventDispatcher.
 *
 * @package Drupal\annonce
 */
class AnnonceEventDispatcher implements EventSubscriberInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  protected $database;

  /**
   * Constructs a new AnnonceEventDispatcher object.
   */
  public function __construct(AccountProxy $current_user, Connection $database) {
    $this->currentUser = $current_user;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {

//    kint(HttpKernel\KernelEvents::VIEW);
    //$events[HttpKernel\KernelEvents::VIEW] = ['countViews'];
    $events[HttpKernel\KernelEvents::REQUEST] = ['countViews'];
    //$events[HttpKernel\KernelEvents::RESPONSE] = ['getResp'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function countViews(Event $event) {

    $annonce = \Drupal::service('current_route_match')->getParameter('annonce');
    if ($annonce) {
      // Insert if key are not existing with the given value otherwise update.
      $query = $this->database->merge('annonce_views_history')
        ->key(['uid' => $this->currentUser->id(), 'nid'=> $annonce->id()])
        ->fields([
          'nid' => $annonce->id(),
          'uid' => $this->currentUser->id(),
          'views' => 1
        ])
        ->expression('views', 'views + :inc', array(':inc' => 1));
      $query->execute();
/*
      $query = $this->database->upsert('annonce_views_history')
      $query->fields([
        'uid',
        'nid',
        'views'
      ]);
      $query->values([
        $this->currentUser->id(),
        $annonce->id(),
        1
      ]);
      $query->key('hid');
      $query->condition('uid', $this->currentUser->id(), '=');
      $query->condition('nid', $annonce->id(), '=');
      $query->execute();
*/
/*
      $result = $this->database->select('annonce_views_history', 'a')
        ->fields('a', ['nid', 'uid', 'views'])
        ->condition('uid', $this->currentUser->id(), '=')
        ->condition('nid', $annonce->id(), '=')
        ->execute()->fetchAssoc();

      if ($result) {
        $this->database
          ->update('annonce_views_history')
          ->fields([
            'views' => ($result['views']+1)
          ])
          ->condition('uid', $this->currentUser->id(), '=')
          ->condition('nid', $annonce->id(), '=')
          ->execute();
      }
      else {
        $this->database
          ->insert('annonce_views_history')
          ->fields(
            [
              'nid' => $annonce->id(),
              'uid' => $this->currentUser->id(),
              'views' => 1
            ]
          )->execute();
      }
*/
    }


/*
    try {
      $current_path = \Drupal::service('path.current')->getPath();
      $params = \Drupal\Core\Url::fromUserInput($current_path)->getRouteParameters();

      // Only if there is an annonce parameter
      if (isset($params['annonce'])) {
        $annonce = \Drupal\node\Entity\Node::load($params['annonce']);
        $result = $this->database->select('annonce_views_history', 'a')
          ->fields('a', ['nid', 'uid', 'views'])
          ->condition('uid', $this->currentUser->id(), '=')
          ->condition('nid', $annonce->id(), '=')
          ->execute()->fetchAssoc();

        if ($result) {
          $this->database
            ->update('annonce_views_history')
            ->fields([
              'views' => ($result['views']+1)
            ])
            ->condition('uid', $this->currentUser->id(), '=')
            ->condition('nid', $annonce->id(), '=')
            ->execute();
        }
        else {
          $this->database
            ->insert('annonce_views_history')
            ->fields(
              [
                'nid' => $annonce->id(),
                'uid' => $this->currentUser->id(),
                'views' => 1
              ]
            )->execute();
        }
      }
    }
    catch (	\Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }
*/
  }

  public function displayM(Event $event) {
//    kint($event->getRequest());
//    kint($event->getRequest()->getRequestUri());
//    drupal_set_message(t('Event for %username', ['%username' => $this->currentUser->getUsername()]), 'status', TRUE);
  }
  public function getResp(Event $event) {
    //kint($event->getResponse());
    //drupal_set_message(t('Event for %username', ['%username' => $this->currentUser->getUsername()]), 'status', TRUE);
  }

}
