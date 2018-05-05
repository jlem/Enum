<?php namespace Jlem\Enum;

use InvalidArgumentException;
use ReflectionClass;

abstract class Enum
{
    protected $value;
    protected static $cache = array();

    public function __construct($value)
    {
        if (!static::valueIsValid($value)) {
            $message = "Cannot create ". get_called_class() . " with value of $value.";
            $message .= is_string($value) ? "Expected a numeric value, got a string instead" : '';
            throw new InvalidArgumentException($message);
        }

        $this->value = $value;
    }

    abstract public static function getStrings();

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
     * Returns the string representing the underlying key of the instantiated enum
     * @example: if const FOO = 1, then $enum->key() returns 'FOO'
     * @return string
     */
    public function key()
    {
        return array_search($this->value, self::constants(), true);
    }

    /**
     * Returns the underlying value this enum instance represents
     * @example if const FOO = 1, then $enum->value() returns 1
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Returns the string representation for the current enum instance
     * May be supplied with the name of a formatter function (either from the global PHP library, or "static::<method_name>")
     * @example if SELF::FOO => 'foo', then $enum->string() returns 'foo'
     * @param null|string $formatter
     * @return string
     */
    public function string($formatter = null)
    {
        $strings = static::getStrings();
        $string = $strings[$this->value];
        return ($formatter) ? Enum::format($formatter, $string) : $string;
    }

    /**
     * Returns an array of the underlying constants where the constant keys are string keys, and the values are their value
     * @example if const FOO = 1; then MyEnum::constants() returns ['FOO' => 1]
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
     * @param  string $key
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
     * @param string $keyBy
     * @return array
     */
    public static function instances($keyBy = 'value')
    {
        return static::arrayOf('instance', $keyBy);
    }


    /**
     * Returns the enumeration constants as an array
     * @param string $keyBy
     * @return array
     */
    public static function keys($keyBy = 'value')
    {
        return static::arrayOf('key', $keyBy);
    }


    /**
     * Returns the enumeration constants as an array
     * @param string $keyBy
     * @return array
     */
    public static function values($keyBy = 'value')
    {
        return static::arrayOf('value', $keyBy);
    }


    /**
     * Gets the array of string values for the Enum class, formatting each one by the optional formatter
     * @param  array $formatter
     * @param string $keyBy
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
        if (method_exists(get_called_class(), $formatter)) {
            return call_user_func('static::'.$formatter, $value);
        }

        if (is_callable($formatter)) {
            return $formatter($value);
        }

        throw new InvalidArgumentException("Invalid or undefined formatter function");
    }


    /**
     * Used exclusively for construction of new enum via static calls to the class's constants
     * @param $name
     * @param $arguments
     * @return static
     */

    public static function __callStatic($name, $arguments)
    {
        if (!static::keyIsValid($name)) {
            throw new InvalidArgumentException("Cannot create ". get_called_class() . " with constant of $name");
        }

        return new static(constant("static::$name"));
    }

    /**
     * Automatically converts the constants keys into lower case strings, replacing "_" with " ".
     * @param null|string $formatter
     * @return array
     */
    protected static function autoStrings($formatter = null)
    {
        $constants = array_flip(static::constants());
        array_walk($constants, function(&$value) use ($formatter) {
            $value = $formatter ? static::format($formatter, $value) : strtolower(str_replace("_", " ", $value));
        });
        return $constants;
    }
}
