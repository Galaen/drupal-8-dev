<?php

/**
 * @file
 * Contains \Drupal\hello\Controller\HelloController.
 */

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloRssController extends ControllerBase {
    public function content() {
/*
      $myresponse = array(
        'success' => true,
        'content' => array(
         'main_content' => 'A long string',
         'secondary_content' => 'another string'
        )
      );

      $finalResponse = json_encode($myresponse);
        
      $response = new Response($finalResponse);

        //$response = new Response("toto");

        //$response->setContent('<html><body><h1>Hello world!</h1></body></html>');

        //$response->headers->set('Content-Type', 'text/html');
        $response->headers->set('Content-Type', 'application/json');
*/

        $response = new JsonResponse(array('data' => 123));

        //$response
        return $response;

        //return array ('#markup' => 'test');
    }
}
