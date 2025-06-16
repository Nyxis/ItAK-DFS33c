<?php

namespace Lib;

interface Datastore
{
    /**
     * Load data from the datastore
     * @return array
     */
    public function loadData(): array;
} 