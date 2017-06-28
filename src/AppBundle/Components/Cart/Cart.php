<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 26.06.17
 * Time: 21:36
 */

namespace AppBundle\Components\Cart;


class Cart implements \Countable, \ArrayAccess, \Iterator
{
    /**
     * @var int
     */
    private $offset = 0;

    /**
     * @var CartItem[]
     */
    private $cartItems = [];

    /**
     * @param IBuyable $product
     * @param int      $amount
     *
     * @return Cart
     */
    public function add(IBuyable $product, int $amount = 1): Cart
    {
        if (isset($this->cartItems[$product->getId()])) {
            $amount = $this->cartItems[$product->getId()]->getAmount() + $amount;
        }

        return $this->set($product, $amount);
    }

    /**
     * @param IBuyable $product
     * @param int      $amount
     *
     * @return $this
     */
    public function set(IBuyable $product, int $amount)
    {
        if ($amount <= 0) {
            if (isset($this->cartItems[$product->getId()])) {
                unset($this->cartItems[$product->getId()]);
            }

            return $this;
        }

        $this->cartItems[$product->getId()] = new CartItem($product, $amount);

        return $this;
    }

    /**
     * @param IBuyable $product
     * @param int      $amount
     *
     * @return Cart
     */
    public function remove(IBuyable $product, int $amount = 1): Cart
    {
        if (!isset($this->cartItems[$product->getId()])) {
            return $this;
        }

        return $this->set($product, $this->cartItems[$product->getId()]->getAmount() - $amount);
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->cartItems);
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset(array_values($this->cartItems)[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed|CartItem Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return array_values($this->cartItems)[$offset];
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed          $offset <p>
     *                               The offset to assign the value to.
     *                               </p>
     * @param mixed|IBuyable $value  <p>
     *                               The value to set.
     *                               </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if (!$value instanceof IBuyable) {
            throw new \TypeError('The object added to cart must implement interface '.IBuyable::class);
        }

        $this->add($value);
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->remove($this[$offset]->getProduct());
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->offsetGet($this->offset);
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->offset++;
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->offset;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->offsetExists($this->offset);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->offset = 0;
    }
}