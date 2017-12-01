<?php
declare(strict_types=1);
/**
 * This file is part of the Set package.
 * For the full copyright information please view the LICENCE file that was
 * distributed with this package.
 *
 * @copyright Simon Deeley 2017
 */

namespace simondeeley;

use SplFixedArray;
use simondeeley\Type\Type;
use simondeeley\Type\SetType;
use simondeeley\Type\TypeEquality;
use simondeeley\ImmutableArrayTypeObject;
use simondeeley\Helpers\TypeEqualityHelperMethods;

/**
 * Set type object
 *
 * Implements a mathematical set in PHP. A mathematical set is an unordered list
 * of items where two lists are considered equal if both sets contain the same
 * items but not necessarily in the same order or in the same quantity. So, for
 * example:
 *      Set(1, 2, 3) === Set(3, 1, 2);
 *      Set(1, 2, 3) === Set(1, 2, 2, 3);
 * but
 *      Set(1, 2) !== Set(1, 2, 3);
 *
 * @author Simon Deeley <s.deeley@icloud.com>
 */
abstract class Set extends ImmutableArrayTypeObject implements SetType, TypeEquality
{
    use TypeEqualityHelperMethods;

    /**
     * @var SplFixedArray
     */
    protected $data;

    /**
     * Construct a new Set
     *
     * @final
     * @param mixed ...$items - accepts any number of items
     * @return void
     */
    final public function __construct(...$items)
    {
        $this->data = SplFixedArray::fromArray($items);
    }

    /**
     * Compare equality of two Sets
     *
     * @final
     * @param Type $set - The set to compare with
     * @param int $flags - Optional flags
     * @return bool
     * @throws InvalidArgumentException - thrown if $type is not of an instance
     *                                    of {@link Set}
     */
    final public function equals(Type $set, int $flags = TypeEquality::IGNORE_OBJECT_IDENTITY): bool
    {
        if (false === $set instanceof SetType) {
            throw new InvalidArgumentException(sprintf(
                'Cannot compare %s with %s as they are not of the same type',
                get_class($this),
                get_class($tuple)
            ));
        }

        // Loop through items in $this, if any do not exist in $set then the
        // two Sets are not equal.
        foreach($this->data as $item) {
            if (0 === count(array_search($item, $set->data->toArray(), true))) {
                return false;
            }
        }

        // Loop through items in $set. If any do not exist in $this then they
        // they are not equal.
        foreach ($set->data as $item) {
            if (false === count(array_search($item, $this->data->toArray(), true))) {
                return false;
            }
        }

        return $this->isSameTypeAs($set, $flags)
            && $this->isSameObjectAs($set, $flags);
    }
}
