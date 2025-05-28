<?php

enum ResultatStatut: string {
    case ECHEC = 'Échec';
    case REUSSITE = 'Réussite';
    case REUSSITE_CRITIQUE = 'Réussite Critique';
    case FUMBLE = 'Fumble';
}
