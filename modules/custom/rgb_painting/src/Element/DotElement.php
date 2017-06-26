<?php

namespace Drupal\rgb_painting\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Component\Utility\Html as HtmlUtility;
use Drupal\Core\Url;

/**
 * Provides a render element for a Dot. A custom element to paint.
 *
 * @RenderElement("dot")
 */
class DotElement extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#theme' => 'dot',
      '#pre_render' => [
        [$class, 'preRenderMyElement'],
      ],
      // HTML5 Shiv
//      '#attached' => [
//        'library' => ['core/html5shiv'],
//      ],
    ];
  }

  /**
   * Prepare the render array for the template.
   */
  public static function preRenderMyElement($element) {
    /*
    // Conditionally invoke self::preRenderAjaxForm(), if #ajax is set.
    if (isset($element['#ajax']) && !isset($element['#ajax_processed'])) {
      // If no HTML ID was found above, automatically create one.
      if (!isset($element['#id'])) {
        $element['#id'] = $element['#options']['attributes']['id'] = HtmlUtility::getUniqueId('dot');
      }

      $element = static::preRenderAjaxForm($element);
    }
*/

    if (!isset($element['#ajax_processed'])) {
      $element['#id'] = $element['#options']['attributes']['id'] = HtmlUtility::getUniqueId('dot');

      $element['#ajax'] = [
        'event' => 'click',
        'url' => Url::fromRoute('rgb_painting.path_with_data', ["dot" => $element['#id']]),
        'progress' => ''
      ];
      $element = static::preRenderAjaxForm($element);
    }

    if (!isset($element['#color'])) {
      $element['#color'] = '#FF0000';
    }

    $element['#attributes']['id'] = $element['#id'];
    $element['#attributes']['class'] = ['square'];
    $element['#attributes']['style'] = ['background-color:'.$element['#color'].';'];
    //$element['#markup'] ='<div id="'. $element['#id'] . '" class="square square-green" style="background-color: #FF0000;"></div>';

/*
    // Create a link render array using our #label.
    $element['link'] = [
      '#type' => 'link',
      '#title' => $element['#label'],
      '#url' => Url::fromUri('http://www.drupal.org'),
    ];

    // Create a description render array using #description.
    $element['description'] = [
      '#markup' => $element['#description']
    ];

    $element['pre_render_addition'] = [
      '#markup' => 'Additional text.'
    ];

    // Create a variable.
    $element['#random_number'] = rand(0,100);
*/
    // Add the library
//    $element['#attached'] = [
//      'library' => [
//        'theme_example/sample_library',
//      ],
//      'drupalSettings' => [
//        'sampleLibrary' => [
//          'mySetting' => 'hello world',
//        ],
//      ],
//    ];

    return $element;
  }

}
