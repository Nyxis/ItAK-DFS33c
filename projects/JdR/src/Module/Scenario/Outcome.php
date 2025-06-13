<?php

namespace Module\Scenario;

enum Outcome : string
{
    case FUMBLE = 'fumble';
    case FAILURE = 'failure';
    case SUCCESS = 'success';
    case CRITICAL = 'critical';
}
