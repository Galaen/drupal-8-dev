<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class HelloAjaxTestController extends ControllerBase {
  public function render() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t('Hello World!'),
    );
/*
    // This is the important part, because will render only the TWIG template.

    $response =  = new AjaxResponse();//new Response();//render($build));

    $response->addCommand(new HtmlCommand('#foo-replace', render($build)));
    return $response;//new Response(render($build));
*/

    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#foo-replace', render($build)));
    return $response;
    //return new Response(render($build));
  }
}