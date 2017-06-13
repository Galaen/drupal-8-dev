<?php
/**
 * Created by PhpStorm.
 * User: POE5
 * Date: 09/06/2017
 * Time: 11:54
 */

namespace drupal\hello\Form;

//use Drupal\Core\Ajax\AjaxResponse;
//use Drupal\Core\Ajax\CssCommand;
//use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class HelloAdminForm extends ConfigFormBase {

//  protected $step = '-';

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'hello_admin_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $color = $this->config('hello.config')->get('block-color');
   // kint($color);
    $form['color_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select element'),
      '#options' => [
        'red' => $this->t('Red'),
        'green' => $this->t('Green'),
        'blue' => $this->t('Blue')
      ],
      '#default_value' => $color,
    ];

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hello.config')->set('block-color', $form_state->getValue('color_select'))->save();

    //$block_manager = \Drupal::service('plugin.manager.block');
    //kint($block_manager);
/*
    $query = $blockEntityManager = \Drupal::service('entity.manager')->getStorage('block')->getQuery();
    $bids = $query->execute();
    //kint($blockEntityManager);
    //kint($bids);
    $blocks = \Drupal::service('entity.manager')->getStorage('block')->loadMultiple($bids);
    kint($blocks);


    foreach ($blocks as $block) {
      kint($block->getEntityType());
      exit();
    }

    exit();
*/
    \Drupal::entityTypeManager()->getViewBuilder('block')->resetCache();


    //$blockEntityManager->resetCache();
    //exit();

    //$block_manager->clearCachedDefinitions();

    //exit();

    //\Drupal::service('cache_tags.invalidator')->invalidateTags('block');


    parent::submitForm($form, $form_state);
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['hello.config'];
  }
}