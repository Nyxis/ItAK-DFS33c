<?php

namespace Module\Character\Model;

enum EquipmentCategory : string
{
    case WEAPON = 'weapon';
    case ARMOR = 'armor';
    case GLOVES = 'gloves';
    case BOOTS = 'boots';
    case HELM = 'helm';
    case BELT = 'belt';
    case TRINKET = 'trinket';
}
