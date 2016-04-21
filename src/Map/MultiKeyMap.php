<?php

namespace Argon\PhpCommon\Map;

use Argon\PhpCommon\Util\Hash;

/**
 * Class MultiKeyMap
 *
 * Map which is able to associate multiple keys with one item / value
 *
 * @package Argon\PhpCommon\Map
 * @author Dominic Roenicke <argonthechecker@gmail.com>
 */
class MultiKeyMap
{
    /**
     * Holds all items of the map
     *
     * @var mixed[]
     */
    private $items = array();

    /**
     * Holds all relations from keys to items
     *
     * @var array
     */
    private $keyMap = array();

    /**
     * Holds all relations from hash information to items
     *
     * @var array
     */
    private $hashMap = array();

    /**
     * @var Hash
     */
    private $hashUtil;

    /**
     * MultiKeyMap constructor.
     */
    public function __construct()
    {
        $this->hashUtil = Hash::getInstance();
    }

    /**
     * Adds a new item to the map.
     * Creates the relations to all given keys with this item.
     * When forcing an overwrite, items already accociated with given keys, will be overwritten with the new item.
     *
     * @param array   $keys      list of keys relating to the item
     * @param mixed   $item      item to insert
     * @param boolean $overwrite flag for forcing an overwrite
     *
     * @return $this
     */
    public function add(array $keys, $item, $overwrite = false)
    {
        if ($overwrite !== false) {
            // do overwrite
            $this->set($keys, $item);
        } else {

        }

        return $this;
    }

    /**
     * Sets a new relation for given item and keys.
     * Already existing relation for the given key, will be overwritten with the new item.
     *
     * @param array $keys list of keys relating to the item
     * @param mixed $item item to insert
     *
     * @return $this
     */
    public function set(array $keys, $item)
    {
        foreach ($keys as $key) {

        }

        return $this;
    }

    /**
     * Returns the item associated to the given key.
     * When the given key does not exist, null wil be returned.
     *
     * @param string|int $key associated key
     *
     * @return mixed|null item
     */
    public function get($key)
    {
        $index = $this->getIndexOfKey($key);

        if ($index === null) {
            return null;
        }

        return $this->items[$index];
    }

    /**
     * Checks which keys of the given already exists in the map.
     * Will return a list with all existing keys.
     * When there's no key in the map, an empty array will be returned.
     *
     * @param array $keys list of keys
     *
     * @return array list of existing keys
     */
    public function keysExists(array $keys)
    {
        $existingKeys = array();

        foreach ($keys as $key) {
            if ($this->keyExists($key)) {
                $existingKeys[] = $key;
            }
        }

        return $existingKeys;
    }

    /**
     * Checks whether the given key already exists in the map
     *
     * @param string|int $key key to lookup for
     *
     * @return bool
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->keyMap);
    }

    /**
     * Checks whether the given hash already exists in the map
     *
     * @param string $hash hash value to lookup for
     *
     * @return bool
     */
    public function hashExists($hash)
    {
        return array_key_exists($hash, $this->hashMap);
    }

    /**
     * Returns the index of the given key in the items list.
     * When the given key does not exist, null wil be returned.
     *
     * @param string|int $key key to lookup for
     *
     * @return int|null
     */
    public function getIndexOfKey($key)
    {
        if (!$this->keyExists($key)) {
            return null;
        }

        return $this->keyMap[$key];
    }

    /**
     * Returns the index of the given hash in the items list.
     * When the given hash does not exist, null wil be returned.
     *
     * @param string $hash hash value to lookup for
     *
     * @return int|null
     */
    public function getIndexOfHash($hash)
    {
        if (!$this->hashExists($hash)) {
            return null;
        }

        return $this->hashMap[$hash];
    }

    /**
     * Returns the amount of all items in the list
     *
     * @return int
     */
    public function getLength()
    {
        return count($this->items);
    }

    public function setOne($key, $item)
    {


    }
}