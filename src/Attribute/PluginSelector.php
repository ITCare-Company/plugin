<?php

declare(strict_types=1);

namespace Drupal\plugin\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;

/**
 * Provides a plugin selector plugin attribute.
 *
 * @see \Drupal\plugin\Annotation\PluginSelector
 * @see \Drupal\plugin\Plugin\Plugin\PluginSelector\PluginSelectorManager
 * @see plugin_api
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class PluginSelector extends Plugin {

  /**
   * Constructs a PluginSelector attribute.
   *
   * @param string $id
   *   The plugin ID.
   * @param string $label
   *   The translated human-readable plugin name.
   */
  public function __construct(
    public readonly string $id,
    public readonly string $label,
  ) {}

}
