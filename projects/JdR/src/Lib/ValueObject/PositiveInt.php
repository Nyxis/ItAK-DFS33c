<?php

namespace Lib\ValueObject;

final readonly class PositiveInt
{
    public int $value;

    public function __construct(int|PositiveInt $value)
    {
        if (!is_int($value)) {
            $this->value = $value->value;

            return;
        }

        if ($value < 0) {
            throw new \InvalidArgumentException(sprintf(
                'Value has to be positive, %d given.',
                $this->value
            ));
        }

        $this->value = $value;
    }

    public function equals(self $other) : bool
    {
        return $other->value === $this->value;
    }
}
