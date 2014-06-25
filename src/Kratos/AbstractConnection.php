<?php

namespace Kratos;

abstract class AbstractConnection {
	
	protected $collections;
	protected $table;

	// public function __call($name, $arguments = null)
 //    {
 //        // Note: value of $name is case sensitive.
 //        echo "Calling object method '$name' "
 //             . implode(', ', $arguments). "<br />";

 //        return $this;
 //    }
    public function __get($name)
    {
        if (isset($this->collections[$name]))
            return $this->collections[$name];

        if( count($this->collections) == 0)
            $this->table = $name;

        $this->collections[$name] = $name;

        return $this;
    }
    // public function __set($alias, $value)
    // {
    //     $this->collections[$name] = $value;
    //     return $this;
    // }
    // public function __isset($alias)
    // {
    //     return isset($this->collections[$alias]);
    // }
}