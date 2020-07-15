<?php

namespace ImportWP;

class Container
{
    public $providers = [];
    public $classes = [];

    private static $instance;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function setupServiceProviders($is_pro = false)
    {
        $potential_classes = [];

        if (true === $is_pro) {
            $potential_classes = ['ImportWP\Pro\ServiceProvider'];
        } else {
            $potential_classes = ['ImportWP\Free\ServiceProvider'];
        }

        foreach ($potential_classes as $class) {
            $this->maybeAddProvider($class);
        }

        if (!empty($this->providers)) {
            foreach ($this->providers as $provider) {
                $vars = get_object_vars($provider);
                foreach ($vars as $prop => $var) {
                    if (!isset($this->classes[$prop])) {
                        $this->classes[$prop] = $var;
                    }
                }
            }
        }
    }

    public function maybeAddProvider($class)
    {
        if (class_exists($class)) {
            $this->providers[$class] = new $class;
        }
    }

    public function get($id)
    {
        if (empty($this->classes)) {
            $this->setupServiceProviders();
        }

        if (array_key_exists($id, $this->classes)) {
            return $this->classes[$id];
        }

        return false;
    }
}
