<?php
namespace App\Entity;

enum BookStatus: string
{
    case AVAILABLE = 'available';
    case BORROWED = 'borrowed';
    case RESERVED = 'reserved';
    case LOST = 'lost';
} 