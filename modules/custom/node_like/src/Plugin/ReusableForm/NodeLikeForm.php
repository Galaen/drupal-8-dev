<?php

namespace Drupal\node_like\Plugin\ReusableForm;

use Drupal\reusable_forms\ReusableFormPluginBase;

/**
 * Provides a Email form.
 *
 * @ReusableForm(
 *   id = "node_like_form",
 *   name = @Translation("Node Like Form"),
 *   form = "Drupal\node_like\Form\NodeLikeForm"
 * )
 */
class NodeLikeForm extends ReusableFormPluginBase {

}