<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;

class HelloAccessCheck implements AccessCheckInterface {
  public function applies(Route $route) {
    return NULL;
  }

  public function access(Route $route, Request $request = null, AccountInterface $account) {
    $param = $route->getRequirement('_access_hello');

    if ($account->isAnonymous()) {
      return AccessResult::forbidden();
    }

    //$account->getAccount()->created

    $user = \Drupal\user\Entity\User::load($account->id());
    $createDate = $user->getCreatedTime();
    $diffTime = time()-$createDate;

    $h = $diffTime / 3600;
    if ($h >= $param)
      return AccessResult::allowed()->cachePerUser();
    else
      return AccessResult::forbidden();
  }
}