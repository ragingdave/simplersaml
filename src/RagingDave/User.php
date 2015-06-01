<?php namespace RagingDave\SimplerSaml;

use ArrayAccess;
use RagingDave\SimplerSaml\Contracts\User as UserContract;

class User implements ArrayAccess, UserContract
{
	/**
	 * Map Saml properties to internal properties
	 * ie. cn => name or mail => email
	 * @var array
	 */
	protected $property_map = [];

	/**
	 * Holds the raw user data
	 *
	 * @var array
	 */
	protected $user;

	/**
	 * Set the raw user array from the provider.
	 * Basically just add the attributes this way to allow arrayAccess
	 *
	 * @param  array  $user
	 * @return $this
	 */
	public function setRaw(array $user)
	{
		$this->raw_user = $user;
		return $this;
	}

	/**
	 * Get the raw user array from the provider.
	 * Basically just return exactly what we put in.
	 *
	 * @return array
	 */
	public function getRaw()
	{
		return $this->raw_user;
	}

	/**
	 * Map the given array onto the user's properties.
	 *
	 * @param  array  $attributes
	 * @return $this
	 */
	public function map(array $attributes)
	{
		foreach ($attributes as $key => $value) {
			if(count($value) == 1)
			{
				$value = $value[0];
			}

			// Make sure we don't lose any information
			$this->user["raw_$key"] = $value;

			// If the key is present in the property_map use the mapped value
			if (isset($this->property_map[$key]))
			{
				$key = $this->property_map[$key];
				$this->user[$key] = $value;
			}
		}

		return $this;
	}

	/**
	 * Determine if the given raw user attribute exists.
	 *
	 * @param string $offset
	 * @return bool if the offsetExists
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->user);
	}

	/**
	 * Get the given key from the raw user.
	 *
	 * @param  string  $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->user[$offset];
	}

	/**
	 * Set the given attribute on the raw user array.
	 *
	 * @param  string  $offset
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->user[$offset] = $value;
	}

	/**
	 * Unset the given value from the raw user array.
	 *
	 * @param  string  $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($this->user[$offset]);
	}
}