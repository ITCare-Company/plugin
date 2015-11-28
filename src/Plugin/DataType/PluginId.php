<?php

/**
 * @file
 * Contains \Drupal\plugin\Plugin\DataType\PluginId.
 */

namespace Drupal\plugin\Plugin\DataType;

use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\Plugin\DataType\StringData;
use Drupal\plugin\Plugin\Field\FieldType\PluginCollectionItemInterface;

/**
 * Provides a plugin ID data type.
 *
 * @DataType(
 *   id = "plugin_id",
 *   label = @Translation("Plugin ID")
 * )
 */
class PluginId extends StringData {

  // @todo Stop using this once https://www.drupal.org/node/2615790 is fixed.
  use DependencySerializationTrait;
  use PluginCollectionItemPropertyTrait;

  /**
   * {@inheritdoc}
   */
  public function setValue($value, $notify = TRUE) {
    $value = (string) $value;
    $plugin_instance = $this->parent->getContainedPluginInstance();
    if (!$value) {
      $this->parent->resetContainedPluginInstance();
    }
    elseif (!$plugin_instance || $plugin_instance->getPluginId() != $value) {
      $plugin_instance = $this->parent->getPluginType()->getPluginManager()->createInstance($value);
      $this->parent->setContainedPluginInstance($plugin_instance);
    }
    $this->parent->onChange($this->getName());
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $plugin_instance = $this->parent->getContainedPluginInstance();
    if ($plugin_instance) {
      return $plugin_instance->getPluginId();
    }
  }

}
