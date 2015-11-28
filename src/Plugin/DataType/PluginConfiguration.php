<?php

/**
 * @file
 * Contains \Drupal\plugin\Plugin\DataType\PluginConfiguration.
 */

namespace Drupal\plugin\Plugin\DataType;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedData;
use Drupal\plugin\Plugin\Field\FieldType\PluginCollectionItemInterface;

/**
 * Provides a plugin configuration data type.
 *
 * @DataType(
 *   id = "plugin_configuration",
 *   label = @Translation("Plugin configuration")
 * )
 */
class PluginConfiguration extends TypedData {

  // @todo Stop using this once https://www.drupal.org/node/2615790 is fixed.
  use DependencySerializationTrait;
  use PluginCollectionItemPropertyTrait;

  /**
   * The plugin configuration.
   *
   * @var mixed[]
   */
  protected $value;

  /**
   * {@inheritdoc}
   */
  public function setValue($value, $notify = TRUE) {
    $value = (array) $value;
    $plugin_instance = $this->parent->getContainedPluginInstance();
    if ($plugin_instance instanceof ConfigurablePluginInterface) {
      $plugin_instance->setConfiguration($value);
    }
    $this->parent->onChange($this->getName());
  }

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $plugin_instance = $this->parent->getContainedPluginInstance();
    if ($plugin_instance instanceof ConfigurablePluginInterface) {
      return $plugin_instance->getConfiguration();
    }
    return [];
  }

}
