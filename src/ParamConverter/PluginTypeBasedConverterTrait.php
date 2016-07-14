<?php

namespace Drupal\plugin\ParamConverter;

use Drupal\plugin\PluginType\PluginTypeManagerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Validation;

/**
 * Provides scaffolding four plugin type-based route parameter converters.
 */
trait PluginTypeBasedConverterTrait {

  /**
   * The plugin type manager.
   *
   * @var \Drupal\plugin\PluginType\PluginTypeManagerInterface
   */
  protected $pluginTypeManager;

  /**
   * Constructs a new instance.
   *
   * @param \Drupal\plugin\PluginType\PluginTypeManagerInterface $plugin_type_manager
   */
  public function __construct(PluginTypeManagerInterface $plugin_type_manager) {
    $this->pluginTypeManager = $plugin_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    $valid = $this->validateParameterDefinition($definition);
    if (!$valid) {
      return FALSE;
    }

    if (is_null($this->getConverterDefinition($definition))) {
      return FALSE;
    }

    return TRUE;
  }

  /**
   * Gets the
   */

  /**
   * Gets the converter-specific parameter definition.
   *
   * @param mixed[] $definition
   *
   * @return mixed[]|null
   *   The processed definition or NULL if there is no definition
   */
  protected function getConverterDefinition(array $definition) {
    // There is no converter-specific definition.
    if (!array_key_exists($this->getConverterDefinitionKey(), $definition)) {
      return NULL;
    }

    $converter_definition = $definition[$this->getConverterDefinitionKey()];

    // Merge in defaults.
    $converter_definition += [
      'enabled' => TRUE,
    ];

    // The definition is disabled.
    if (!$converter_definition['enabled']) {
      return NULL;
    }

    return $converter_definition;
  }

  /**
   * Validates a route parameter's definition.
   *
   * @param mixed $definition
   *   The route parameter definition to validate.
   *
   * @return bool
   */
  protected function validateParameterDefinition($definition) {
    $validator = Validation::createValidator();
    $constraint = new Collection([
      'allowExtraFields' => TRUE,
      'fields' => [
        $this->getConverterDefinitionKey() => new Optional($this->getConverterDefinitionConstraint()),
      ],
    ]);
    $violations = $validator->validate($definition, $constraint);
    foreach ($violations as $violation) {
      trigger_error(sprintf("Error while validating the route parameter definition in item %s: %s\n\nOriginal data:\n%s", $violation->getPropertyPath(), $violation->getMessage(), var_export($violation->getRoot(), TRUE)), E_USER_WARNING);
    }

    return count($violations) === 0;
  }

  /**
   * Gets the top-level route parameter definition key for this converter.
   *
   * @return string
   */
  abstract protected function getConverterDefinitionKey();

  /**
   * Gets the parameter's converter definition validation constraint.
   *
   * @return \Symfony\Component\Validator\Constraint
   */
  abstract protected function getConverterDefinitionConstraint();

}
