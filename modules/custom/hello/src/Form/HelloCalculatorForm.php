<?php
/**
 * Created by PhpStorm.
 * User: POE5
 * Date: 09/06/2017
 * Time: 11:54
 */

namespace drupal\hello\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class HelloCalculatorForm extends FormBase {

//  protected $step = '-';

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'hello_calculator_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    //$res = $form_state->getStorage();
    $res = $form_state->getBuildInfo();

    /*if ($res && isset($res['result']))*/ {
      $form['markup'] = [
        '#type' => 'markup',
        '#markup' => '<label>Result</label><p id="form-result">' . $res['result'] . '</p>',//$this->step . '</p>',
        '#cache' => ['max-age' => '0'],
      ];
    }

    $form['first_value'] = [
      '#type' => 'number',
      '#title' => $this->t('First Value'),
      '#description' => $this->t('Enter first value'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => [$this, 'validateValues'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="message-first-value"></span>'
    ];
    $form['operator'] = [
      '#type' => 'radios',
      '#title' => $this->t('Operation'),
      '#default_value' => 0,
      '#options' => [
        0 => $this->t('Add'),
        1 => $this->t('Substract'),
        2 => $this->t('Multiply'),
        3 => $this->t('Divide')
      ],
      '#ajax' => [
        'callback' => [$this, 'validateValues'],
        'event' => 'change'
      ]
    ];
    $form['second_value'] = [
      '#type' => 'number',
      '#title' => $this->t('Second Value'),
      '#description' => $this->t('Enter second value'),
      '#required' => TRUE,
      '#default_value' => 0,
      '#ajax' => [
        'callback' => [$this, 'validateValues'],
        'event' => 'change'
      ],
      '#suffix' => '<span class="message-second-value"></span>'
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate')
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state); // TODO: Change the autogenerated stub
    $value1 = $form_state->getValue('first_value');
    $value2 = $form_state->getValue('second_value');
    $operator = $form_state->getValue('operator');

    if ($operator == 3 && $value2 == 0) {
      $form_state->setErrorByName('second_value', $this->t('This Field must not be 0!'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    //parent::submitForm($form, $form_state);
    // TODO: Implement submitForm() method.
    $value1 = $form_state->getValue('first_value');
    $value2 = $form_state->getValue('second_value');
    $operator = $form_state->getValue('operator');
    $res = 0;

    switch ($operator) {
      // Add
      case 0:
        $res = $value1 + $value2;
        break;
      // Substract
      case 1:
        $res = $value1 - $value2;
        break;
      // Multiply
      case 2:
        $res = $value1 * $value2;
        break;
      // Divide
      case 3:
        $res = $value1 / $value2;
        break;
    }

    //drupal_set_message(t("Result: %res", ['%res' => $res]));

    //$form_state->setRedirect('hello.hello');
    //$form_state->setValue('markup', 'bing');

    //$form_state->setStorage(['result' => $res]);
    $form_state->addBuildInfo('result', $res);
    $form_state->setRebuild();
//    $this->step = $res;

  }

  protected function compute($val1, $val2, $operator) {
    $res = '';

    switch ($operator) {
      // Add
      case 0:
        $res = $val1 + $val2;
        break;
      // Substract
      case 1:
        $res = $val1 - $val2;
        break;
      // Multiply
      case 2:
        $res = $val1 * $val2;
        break;
      // Divide
      case 3:
        $res = $val1 / $val2;
        break;
    }

    return $res;
  }

  public function validateValues(array &$form, FormStateInterface $form_state) {

    //$field = $form_state->getTriggeringElement()['#name'];

    $value1 = $form_state->getValue('first_value');
    $value2 = $form_state->getValue('second_value');
    $operator = $form_state->getValue('operator');

    $response = new AjaxResponse();

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

    return $response;
  }
}