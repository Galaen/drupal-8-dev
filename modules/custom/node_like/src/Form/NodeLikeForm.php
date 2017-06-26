<?php

namespace Drupal\node_like\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\reusable_forms\Form\ReusableFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the NodeLikeForm class.
 */
class NodeLikeForm extends ReusableFormBase {

  protected $database;
  protected $currentUser;

  /**
   * {@inheritdoc}.
   */
  public function __construct(Connection $database, AccountInterface $currentUser) {
    $this->database = $database;
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'node_like_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $form['like_button'] = [
      '#type' => 'button',
      '#value' => $this->t('Like Button Ajax Test'),
      '#ajax' => [
        'callback' => [$this, 'likeIt'],
        'event' => 'click'
      ],
    ];

    $form['actions']['submit']['#access'] = false;
    //$form['actions']['submit']['#value'] = $this->t('I like it!');

    return $form;
  }


  public function likeIt(array &$form, FormStateInterface $form_state) {
//    kint($form);
//    exit();

    // Identifiant du noeud.
    $nid = $this->entity->id();
    $uid = $this->currentUser()->id();
    $this->database->merge('node_like_form')
      ->key(array('nid' => $nid, 'uid' => $uid))
      ->fields(array('nid' => $nid, 'uid' => $uid))
      ->execute();

    $likes = $this->database->select('node_like_form', 'nl')
      ->fields('nl', array('uid'))
      ->condition('nid', $nid)
      ->countQuery()
      ->execute()
      ->fetchField();


/*
    //$field = $form_state->getTriggeringElement()['#name'];

    $value1 = $form_state->getValue('first_value');
    $value2 = $form_state->getValue('second_value');
    $operator = $form_state->getValue('operator');
*/

    $build = array(
      '#type' => 'markup',
      '#markup' => t('Likes: %likes', ['%likes' => $likes])
    );
    $response = new AjaxResponse();

    $response->addCommand(new ReplaceCommand('#likes-id', render($build)));
//    $response->addCommand(new HtmlCommand('#likes-id .placeholder', 'Test'));



/*
    if (!is_numeric($value1)) {
      $css = ['border' => '2px solid red'];
      $message = 'Need a numerical value';
    }
    else {
      $css = ['border' => 'none'];
      $message = '';
    }

    $response->addCommand(new CssCommand('#edit-first-value', $css));
    $response->addCommand(new HtmlCommand('.message-first-value', $message));


    if (!is_numeric($value2)) {
      $css = ['border' => '2px solid red'];
      $message = 'Need a numerical value';
    }
    else if ($value2 == 0 && $operator==3) {
      $css = ['border' => '2px solid red'];
      $message = 'Should not be 0 with a division';
    }
    else {
      $css = ['border' => 'none'];
      $message = '';
    }

    $response->addCommand(new CssCommand('#edit-second-value', $css));
    $response->addCommand(new HtmlCommand('.message-second-value', $message));

    if (is_numeric($value1) && is_numeric($value2) && ($value2!=0 || $operator!=3))
      $response->addCommand(new HtmlCommand('#form-result', $this->compute($value1, $value2, $operator)));
    else
      $response->addCommand(new HtmlCommand('#form-result', '-'));
*/
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Identifiant du noeud.
    $nid = $this->entity->id();
    $uid = $this->currentUser()->id();
    $this->database->merge('node_like_form')
      ->key(array('nid' => $nid, 'uid' => $uid))
      ->fields(array('nid' => $nid, 'uid' => $uid))
      ->execute();
  }
}
