<?php

namespace App\Models;

enum Outcome
{
    case FUMBLE;
    case FAILURE;
    case SUCCESS;
    case CRITICAL;
} 