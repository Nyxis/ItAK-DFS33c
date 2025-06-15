<?php

namespace Lib\Persistence;

interface Datasource
{
    public function loadAll() : \Iterator;
}
