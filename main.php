<?php

require_once 'vendor/autoload.php';

use HeightmapToVoxlap;
use UtilLib;

$total = pow(Core::VOXLAP_LENGTH, 2);
$i = new Core('misc/map0.png', 'misc/scale.png');

foreach ($i->generate() as $spanCoord => $spanData) {
    print $spanData;

    $coord = explode(':', $spanCoord);
    Misc::printProgress(($coord[1] + 1) * Core::VOXLAP_LENGTH, $total, STDERR);
}
