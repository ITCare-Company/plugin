<?php

namespace Drupal\Tests\plugin\Unit\PluginDefinition;

use Drupal\Component\Plugin\Derivative\DeriverInterface;
use Drupal\Core\Plugin\Context\ContextDefinitionInterface;
use Drupal\plugin\PluginDefinition\PluginDefinitionValidator;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\plugin\PluginDefinition\PluginDefinitionValidator
 *
 * @group Plugin
 */
class PluginDefinitionValidatorTest extends UnitTestCase {

  /**
   * @covers ::validateClass
   *
   * @dataProvider providerValidateClass
   *
   * @param bool $valid
   *   Whether or not the class is valid.
   * @param string $class
   *   The class to validate.
   */
  public function testValidateClass($valid, $class) {
    if (!$valid) {
      $this->expectException('\InvalidArgumentException');
    }
    $this->assertNull(PluginDefinitionValidator::validateClass($class));
  }

  /**
   * Provides data to self::testValidateClass().
   */
  public static function providerValidateClass() {
    return [
      [TRUE, '\stdClass'],
      [TRUE, __CLASS__],
      [FALSE, NULL],
      [FALSE, 'a_random_name'],
      [FALSE, '\Foo\Bar\Baz\Qux'],
    ];
  }

  /**
   * @covers ::validateDeriverClass
   * @covers ::validateClass
   *
   * @dataProvider providerValidateDeriverClass
   *
   * @param bool $valid
   *   Whether or not the class is valid.
   * @param string $class
   *   The class to validate.
   */
  public function testValidateDeriverClass($valid, $class, $method = NULL) {
    if ($method !== NULL) {
      $class = $this->$method($class);
    }
    if (!$valid) {
      $this->expectException('\InvalidArgumentException');
    }
    $this->assertNull(PluginDefinitionValidator::validateDeriverClass($class));
  }

  /**
   * Provides data to self::testValidateDeriverClass().
   */
  public static function providerValidateDeriverClass() {
    return [
      [TRUE, DeriverInterface::class, 'getMockClassName'],
      [FALSE, NULL],
      [FALSE, '\stdClass'],
      [FALSE, "a_random_name"],
      [FALSE, '\Foo\Bar\Baz\Qux'],
    ];
  }

  /**
   * Gets a mock class name.
   *
   * @param string $class
   *   The class to mock.
   *
   * @return string
   *   The class of the mocked class.
   */
  protected function getMockClassName($class) {
    $mock = $this->createMock($class);
    return get_class($mock);
  }

  /**
   * @covers ::validateContextDefinitions
   *
   * @dataProvider providerValidateContextDefinitions
   *
   * @param bool $valid
   *   Whether or not the class is valid.
   * @param mixed[] $definitions
   *   The context definitions to validate.
   */
  public function testValidateContextDefinitions($valid, array $definitions, $method = NULL) {
    if ($method !== NULL) {
      $definitions = array_map(fn($class) => $this->$method($class), $definitions);
    }
    if (!$valid) {
      $this->expectException('\InvalidArgumentException');
    }
    $this->assertNull(PluginDefinitionValidator::validateContextDefinitions($definitions));
  }

  /**
   * Provides data to self::testValidateContextDefinitions().
   */
  public static function providerValidateContextDefinitions() {
    return [
      [TRUE, []],
      [TRUE, [ContextDefinitionInterface::class], 'createMock'],
      [FALSE, [ContextDefinitionInterface::class], 'getMockClassName'],
      [FALSE, ['a_random_name']],
      [FALSE, [ContextDefinitionInterface::class]],
    ];
  }

}
