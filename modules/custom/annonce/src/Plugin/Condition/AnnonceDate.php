<?php

namespace Drupal\annonce\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
* Provides a 'Annonce date' condition to enable a condition based in module selected status.
*
* @Condition(
*   id = "annonce_date",
*   label = @Translation("Annonce date"),
* )
*
*/
class AnnonceDate extends ConditionPluginBase {

/**
* {@inheritdoc}
*/
public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
{
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition
    );
}

/**
 * Creates a new AnnonceDate object.
 *
 * @param array $configuration
 *   The plugin configuration, i.e. an array with configuration values keyed
 *   by configuration option name. The special key 'context' may be used to
 *   initialize the defined contexts by setting it to an array of context
 *   values keyed by context names.
 * @param string $plugin_id
 *   The plugin_id for the plugin instance.
 * @param mixed $plugin_definition
 *   The plugin implementation definition.
 */
 public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
 }

 /**
   * {@inheritdoc}
   */
 public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
   $form = parent::buildConfigurationForm($form, $form_state);

   $form['start_date'] = [
     '#type' => 'date',
     '#title' => $this->t('Stating Date'),
     '#description' => $this->t('Enter start date'),
     '#required' => TRUE,
     '#default_value' => $this->configuration['start_date']
   ];

   $form['end_date'] = [
     '#type' => 'date',
     '#title' => $this->t('End Date'),
     '#description' => $this->t('Enter end date'),
     '#required' => TRUE,
     '#default_value' => $this->configuration['end_date']
   ];

   $form['negate']['#access'] = FALSE;

   return $form;
 }

/**
 * {@inheritdoc}
 */
 public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
   $this->configuration['start_date'] = $form_state->getValue('start_date');
   $this->configuration['end_date'] = $form_state->getValue('end_date');



 //    $this->configuration['module'] = $form_state->getValue('module');
     parent::submitConfigurationForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function defaultConfiguration() {
    return ['start_date' => '2017-01-01', 'end_date' => '2017-01-01'] + parent::defaultConfiguration();
 }

 /*
 public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
   parent::validateConfigurationForm($form, $form_state);

   $form_state->setErrorByName('end_date', $this->t('This Field must not be 0!'));
 }
*/

  /**
  * Evaluates the condition and returns TRUE or FALSE accordingly.
  *
  * @return bool
  *   TRUE if the condition has been met, FALSE otherwise.
  */
  public function evaluate() {
    $currentTime = time();

    return (($currentTime >= strtotime($this->configuration['start_date']))
    &&      ($currentTime < strtotime($this->configuration['end_date'])));
    /*
      if (empty($this->configuration['start_date']) && !$this->isNegated()) {
          return TRUE;
      }

      $module = $this->configuration['module'];
      $modules = system_rebuild_module_data();

      return $modules[$module]->status;
*/
  }

/**
 * Provides a human readable summary of the condition's configuration.
 */
 public function summary()
 {
   /*
     $module = $this->getContextValue('module');
     $modules = system_rebuild_module_data();

     $status = ($modules[$module]->status)?t('enabled'):t('disabled');
*/
     return t('Youpi');
 }

}
