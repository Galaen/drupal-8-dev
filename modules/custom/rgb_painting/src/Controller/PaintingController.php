<?php

namespace Drupal\rgb_painting\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Component\Utility\Color as ColorUtility;

/**
 * Class PaintingController.
 *
 * @package Drupal\rgb_painting\Controller
 */
class PaintingController extends ControllerBase {

  /**
   * Drupal\Core\Database\Connection definition.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new PaintingController object.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Hello.
   *
   * @return array|string
   *   Return Hello string.
   */
  public function render($name) {

    $intro['intro'] = [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: hello with parameter(s): %name', ['%name' => $name]),
    ];

    $link = [
      '#title' => $this->t('Click me for a surprise!!!'),
      '#type' => 'link',
      '#url' => Url::fromRoute('rgb_painting.path_with_data'), //Url::fromRoute('examples.description'),
      '#prefix' => '<div id="foo-replace">',
      '#suffix' => '</div>',
      //'#id' => 'foo-replace',
      '#ajax' => [
        //'event' => 'mousedown',
        //'method' => 'replaceWith',
        //'wrapper' => 'foo-replace',
        'effect' => 'fade'
      ]
    ];

    $class = get_class($this);

    $markup1[] = [
      '#type' => 'markup',
      '#markup' => '<div id="the-square1" class="square square-red"></div>',
      //'#url' => Url::fromRoute('rgb_painting.path_with_data'), //Url::fromRoute('examples.description'),
      '#id' => 'the-square1',
      '#pre_render' => [
        [$class, 'preRenderAjaxForm'],
      ],
      '#ajax' => [
        //'callback' => 'Drupal\rgb_painting\Controller\PaintingController::autosave',
        'event' => 'click',
        //'method' => 'replaceWith',
        //'wrapper' => 'foo-replace',
        //'effect' => 'fade',
        'url' => Url::fromRoute('rgb_painting.path_with_data', ["dot" => "1"]),
        'progress' => ''
      ]
    ];

    for ($x = 0; $x <= 10; $x++) {
      $dots[] = [
        '#type' => 'dot',
        '#color' => ColorUtility::rgbToHex([rand(0,255), rand(0,255), rand(0,255)])
      ];
    }

    return [
//      'intro' => $intro,
//      'link' => $link,
//      'markup1' => $markup1,
      'dots' => $dots,
      // Attach CSS
      '#attached' => [
        'library' => [
          'rgb_painting/rgb-painting',
        ]
      ]
    ];
  }

  public function ajaxResp($dot) {
//    $build = array(
//      '#type' => 'markup',
//      '#markup' => '<div id="the-square'.$name.'" class="square '.$class.'"></div>',
//    );

    $response = new AjaxResponse();
    //$response->addCommand(new ReplaceCommand('#the-square'.$name, render($build)));
    $response->addCommand(new InvokeCommand('#'.$dot, 'css', ['background-color', ColorUtility::rgbToHex([rand(0,255), rand(0,255), rand(0,255)])]));
    return $response;
  }

}
