<?php

require_once 'vendor/autoload.php';

$total = pow(\HeightmapToVoxlap\Core::VOXLAP_LENGTH, 2);
$i = new \HeightmapToVoxlap\Core('res/map0.png', 'res/scale.png');

foreach ($i->generate() as $spanCoord => $spanData) {
    print $spanData;

    $coord = explode(':', $spanCoord);
    \HeightmapToVoxlap\Util::printProgress(($coord[1] + 1) * \HeightmapToVoxlap\Core::VOXLAP_LENGTH, $total, STDERR);
}
