<?php namespace Ryantxr\Helper;

/**
 *  
 *
 *
 *  @author Ryan Teixeira
 */
class Transformer
{
    /**  @var array $compiledFilter holds the transform rules in an easy to process format */
    protected $compiledFilter;

    public function __construct($filter)
    {
        $this->compile($filter);
    }

    /**
     * Pass it an associative array which can contain other associative arrays.
     * @param array associative array to filter
     * @return array 
     */
    public function filter($data)
    {
        $output = [];
        foreach ( $this->compiledFilter as $filter ) {
            $output[$filter['key']] = $this->arrayGet($data, $filter['path']);
        }
        return $output;
    }

    private function compile($filter)
    {
        $a = explode(',', $filter);
        foreach ( $a as $row ) {
            // Each rule is either 
            //   xxxx=rule where xxxx is the key in the output
            // or
            //   rule where rule is the key in the output
            $rule = explode('=', $row);
            if ( count($rule) == 1 ) {
                $rule[1] = $rule[0];
            }
            $this->compiledFilter[] = ['key' => $rule[0], 'path' => $rule[1]];
        }
        //print_r($this->compiledFilter);
   }


    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array  $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function arrayGet($array, $key, $default = null)
    {
        if ( ! $this->arrayAccessible($array) ) {
            return $this->value($default);
        }
        if ( is_null($key) ) {
            return $array;
        }
        if ( $this->arrayExists($array, $key) ) {
            return $array[$key];
        }
        if ( strpos($key, '.') === false ) {
            return $array[$key] ?? $this->value($default);
        }
        foreach ( explode('.', $key) as $segment ) {
            if ( $this->arrayAccessible($array) && $this->arrayExists($array, $segment) ) {
                $array = $array[$segment];
            } else {
                return $this->value($default);
            }
        }
        return $array;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    function arrayExists($array, $key)
    {
       return array_key_exists($key, $array);
    }

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    function arrayAccessible($value)
    {
        return is_array($value);
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }   
}
