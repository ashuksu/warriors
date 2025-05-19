<?php

namespace Services;

/**
 * Utility class for resolving config variables in strings
 * Replaces references to config variables with their actual values
 */
class ConfigVarResolver
{
    private static $instance = null;

    /**
     * Private constructor to enforce singleton pattern
     */
    private function __construct()
    {
    }

    /**
     * Get singleton instance
     *
     * @return ConfigVarResolver
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Resolve config variables in a string
     * 
     * @param string $value The string that may contain variable references
     * @return string The string with variable references replaced with their values
     */
    public function resolveValue($value)
    {
        // If not a string, return as is
        if (!is_string($value)) {
            return $value;
        }

        // Check for defined constants (like APP_PATH, PROJECT_ROOT)
        if (defined($value)) {
            return constant($value);
        }

        // Check for variable references with $ prefix
        if (strpos($value, '$') === 0) {
            $varName = substr($value, 1);
            // Check if the variable exists in the global scope
            if (isset($GLOBALS[$varName])) {
                return $GLOBALS[$varName];
            }
        }

        // Check for {{VARIABLE}} format
        $value = $this->resolveTemplateVariables($value);

        // Process strings that might contain variable references
        // This handles both standalone variables and variables embedded within strings
        return preg_replace_callback('/(\$[A-Za-z_][A-Za-z0-9_]*|\b[A-Z_][A-Z0-9_]*\b)/', function($matches) {
            $match = $matches[0];

            // Handle variables with $ prefix
            if (strpos($match, '$') === 0) {
                $varName = substr($match, 1);
                if (isset($GLOBALS[$varName])) {
                    return $GLOBALS[$varName];
                }
            } 
            // Handle constants
            else if (defined($match)) {
                return constant($match);
            }

            // Return original if not found
            return $match;
        }, $value);
    }

    /**
     * Resolve template variables in {{VARIABLE}} format
     * 
     * @param string $value The string that may contain template variables
     * @return string The string with template variables replaced with their values
     */
    public function resolveTemplateVariables($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        // Replace {{VARIABLE}} with the value of $VARIABLE
        return preg_replace_callback('/\{\{([A-Za-z_][A-Za-z0-9_]*)\}\}/', function($matches) {
            $varName = $matches[1];

            // Check if the variable exists in the global scope
            if (isset($GLOBALS[$varName])) {
                return $GLOBALS[$varName];
            }

            // Check if it's a defined constant
            if (defined($varName)) {
                return constant($varName);
            }

            // Return original if not found
            return $matches[0];
        }, $value);
    }

    /**
     * Recursively resolve config variables in an array
     * 
     * @param array $data The array that may contain variable references
     * @return array The array with variable references replaced with their values
     */
    public function resolveArray($data)
    {
        if (!is_array($data)) {
            return $this->resolveValue($data);
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->resolveArray($value);
            } else {
                $data[$key] = $this->resolveValue($value);
            }
        }

        return $data;
    }
}
