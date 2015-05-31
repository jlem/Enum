<?php namespace Jlem\Enum;

use InvalidArgumentException;
use ReflectionClass;

class Enum
{
    protected $value;
    protected static $cache = array();

    public function __construct($value)
    {

        if (!static::valueIsValid($value)) {
            throw new InvalidArgumentException("Cannot create ". get_called_class() . " with value of $value");
        }

        $this->value = $value;
    }


    /**
     * Automagically casts the current instance to a string when used in a string context
     *
     * @return string
     */

    public function __toString()
    {
        return $this->string();
    }


    /**
     * Converts enum to its underlying key
     *
     * @return [type] [description]
     */

    public function key()
    {
        return array_search($this->value, self::constants(), true);
    }


    /**
     * Converts enum to its underlying value
     *
     * @param  mixed $constant
     * @return string
     */

    public function value()
    {
        return $this->value;
    }


    /**
     * Converts enum to its underlying string, and formats it with the optional formatter
     *
     * @param  mixed $constant
     * @return string
     */

    public function string($formatter = null)
    {
        $strings = static::getStrings();
        $string = $strings[$this->value];
        return ($formatter) ? Enum::format($formatter, $string) : $string;
    }


    /**
     * Returns an array of enumeration constant keys and their values
     *
     * @return array
     */

    public static function constants()
    {
        $class = get_called_class();

        if (!array_key_exists($class, self::$cache)) {
            $r = new ReflectionClass($class);
            self::$cache[$class] = $r->getConstants();
        }

        return self::$cache[$class];
    }


    /**
     * Returns a complete array of enumeration data
     *
     * @return array
     */

    public static function fullArray()
    {
        $enums = array();
        $strings = static::getStrings();

        foreach (static::constants() as $key => $value)
        {
            $enums[] = array(
                'key' => $key,
                'string' => $strings[$value],
                'value' => $value,
                'instance' => new static($value)
            );
        }

        return $enums;
    }


    /**
     * Returns an array of enums keyed and valued by the specified arguments
     *
     * @param  string $type
     * @param  string|null $key
     * @return array
     */

    public static function arrayOf($type, $key = 'value')
    {
        $enums = array();

        foreach (static::fullArray() as $enum) {
            $enums[$enum[$key]] = $enum[$type];
        }

        if (is_null($key)) {
            $enums = array_values($enums);
        }

        return $enums;
    }


    /**
     * Returns instances of each enumeration
     *
     * @return array
     */

    public static function instances($keyBy = 'value')
    {
        return static::arrayOf('instance', $keyBy);
    }


    /**
     * Returns the enumeration constants as an array
     *
     * @return array
     */

    public static function keys($keyBy = 'value')
    {
        return static::arrayOf('key', $keyBy);
    }


    /**
     * Returns the enumeration constants as an array
     *
     * @return array
     */

    public static function values($keyBy = 'value')
    {
        return static::arrayOf('value', $keyBy);
    }


    /**
     * Gets the array of string values for the Enum class, formatting each one by the optional formatter
     *
     * @param  array $formatter
     * @return array
     */

    public static function strings($formatter = null, $keyBy = 'value')
    {
        $strings = static::arrayOf('string', $keyBy);

        if ($formatter) {
            array_walk($strings, function(&$string, $index) use ($formatter) {
                $string = Enum::format($formatter, $string);
            });
        }

        return $strings;
    }


    /**
     * Checks to see if the given constant value is valid
     *
     * @param  mixed $value
     * @return bool
     */

    public static function valueIsValid($value)
    {
        return in_array($value, self::constants(), true);
    }


    /**
     * Checks to see if the given constant key is valid
     *
     * @param  mixed $value
     * @return bool
     */

    public static function keyIsValid($key)
    {
        return defined("static::$key");
    }


    /**
     * Runs the formatter over the given value, this can be a pass-through to a php library method, or define your own
     *
     * @param  string $formatter
     * @param  string $value
     * @return string
     */

    public static function format($formatter, $value)
    {
        switch ($formatter)
        {
            // register custom methods above this
            default:
                return $formatter($value);
        }
    }


    /**
     * Used exclusively for construction of new enum via static calls to the class's constants
     *
     */

    public static function __callStatic($name, $arguments)
    {
        if (!static::keyIsValid($name)) {
            throw new InvalidArgumentException("Cannot create ". get_called_class() . " with constant of $name");
        }

        return new static(constant("static::$name"));
    }
}
