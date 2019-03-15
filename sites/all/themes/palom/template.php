<?php

/**
 * @file
 * The primary PHP file for this theme.
 */

function palom_system_info_alter(&$info, $file, $type){
  if ($type == 'theme' && module_exists('tfd7') && ($info['name'] === 'bootstrap' || $info['base theme'] === 'bootstrap')) {
    $info['engine'] = 'twig';
  }
}