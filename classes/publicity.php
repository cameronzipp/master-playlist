<?php

class Publicity
{
    public static string $PUBLIC = "PUBLIC";
    public static string $PRIVATE = "PRIVATE";
    public static string $FRIENDS_ONLY = "FRIENDS_ONLY";

    private string $_current;

    public function __construct($publicity_type = null)
    {
        if ($publicity_type === null) {
            $publicity_type = $this::$PUBLIC;
        }
        $this->_current = $publicity_type;
    }

    public function PUBLIC()
    {
        $this->_current = $this::$PUBLIC;
    }

    public function PRIVATE()
    {
        $this->_current = $this::$PRIVATE;
    }

    public function FRIENDS_ONLY()
    {
        $this->_current = $this::$FRIENDS_ONLY;
    }

    public function get(): string
    {
        return $this->_current;
    }

    public function setPublicity(string $publicity): bool
    {
        switch ($publicity) {
            case $this::$PUBLIC: $this->_current = $this::$PUBLIC;
                return true;
            case $this::$PRIVATE: $this->_current = $this::$PRIVATE;
                return true;
            case $this::$FRIENDS_ONLY: $this->_current = $this::$FRIENDS_ONLY;
                return true;
            default:
                return false;
        }
    }

    public function equals(string $publicity): bool
    {
        return $this->_current === $publicity;
    }
}
