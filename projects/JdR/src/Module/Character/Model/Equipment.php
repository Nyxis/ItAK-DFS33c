<?php

namespace Module\Character\Model;

class Equipment
{
    public function __construct(
        public readonly string $name,
        public readonly EquipmentCategory $category
    ) {
    }
}
