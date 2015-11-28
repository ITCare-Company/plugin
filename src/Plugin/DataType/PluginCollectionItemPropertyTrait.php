<?php

/**
 * @file
 * Contains \Drupal\plugin\Plugin\DataType\PluginCollectionItemPropertyTrait.
 */

namespace Drupal\plugin\Plugin\DataType;

use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\Plugin\DataType\StringData;
use Drupal\plugin\Plugin\Field\FieldType\PluginCollectionItemInterface;

/**
 * Provides common functionality for PluginCollectionItemInterface properties.
 */
trait PluginCollectionItemPropertyTrait {

  /**
   * The parent typed data object.
   *
   * @var \Drupal\plugin\Plugin\Field\FieldType\PluginCollectionItemInterface
   */
  protected $parent;

  /**
   * Constructs a new instance.
   *
   * @param \Drupal\Core\TypedData\DataDefinitionInterface $definition
   *   The data definition.
   * @param string $name
   *   The name of the created property.
   * @param \Drupal\plugin\Plugin\Field\FieldType\PluginCollectionItemInterface $parent
   *   The parent object of the data property.
   */
  public function __construct(DataDefinitionInterface $definition, $name, PluginCollectionItemInterface $parent) {
    parent::__construct($definition, $name, $parent);
  }

}
