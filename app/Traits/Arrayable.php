<?php


namespace Traits;

trait Arrayable
{   public function offsetExists($offset)
{
    return isset($this->items[$offset]);
}

    public function offsetGet($offset)
    {
        if(!$this->offsetExists($offset)) {
            return null;
        }
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        //
    }

    public function offsetUnset($offset)
    {
        if($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }
}