<?php

namespace HeightmapToVoxlap;

/**
 *
 */
class Core
{
    const VOXLAP_LENGTH = 512;
    const COLOR_DIVIDER = 4;
    const CACHE_ACCESS_COUNT = 2;

    protected $heightmapRessource;
    protected $scaleRessource;
    protected $spanMatrix;

    public function __construct($heightmapFilePath, $scaleFilePath)
    {
        // TODO: Check errors
        $this->heightmapRessource = imagecreatefromstring(file_get_contents($heightmapFilePath));
        $this->scaleRessource = imagecreatefromstring(file_get_contents($scaleFilePath));
//      $this->spanMatrix = new MatrixCache(self::VOXLAP_LENGTH, self::CACHE_ACCESS_COUNT);
    }

    /**
     *
     * @return string
     */
    public function generate()
    {
        for ($y = 0; $y < self::VOXLAP_LENGTH; ++$y) {
            for ($x = 0; $x < self::VOXLAP_LENGTH; ++$x) {
                $span = ($x == 0 && $y == 0) ? $this->getSpan($x, $y, 4) : $this->getSpan($x, $y, 3);

                $span->setAdjacentSpan('west', $this->getSpan(Util::modulo($x - 1, self::VOXLAP_LENGTH), $y, 4));
                $span->setAdjacentSpan('east', $this->getSpan(Util::modulo($x + 1, self::VOXLAP_LENGTH), $y, 4));
                $span->setAdjacentSpan('north', $this->getSpan($x, Util::modulo($y - 1, self::VOXLAP_LENGTH), 4));
                $span->setAdjacentSpan('south', $this->getSpan($x, Util::modulo($y + 1, self::VOXLAP_LENGTH), 4));

                yield "$x:$y" => $span->toBinary();
            }
            exit;
        }
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @param int $count
     * @return \HeightmapToVoxlap\Span
     */
    public function getSpan($x, $y, $count)
    {
        // TODO: Check arguments
//      if ($this->spanMatrix->hasSpan($x, $y)) {
//          $span = $this->spanMatrix->getSpan($x, $y);
//      } else {
            $z = $this->getZ($x, $y);
            $color = $this->getColor($x, $y);
            $span = new Span($z, $color);

//          $this->spanMatrix->setSpan($x, $y, $span, $count);
//      }

        return $span;
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @return int
     */
    protected function getZ($x, $y)
    {
        $pixelRgba = imagecolorsforindex($this->heightmapRessource, imagecolorat($this->heightmapRessource, $x, $y));
        $invertedShade = Color::MAX_VALUE - ($pixelRgba['red'] + $pixelRgba['green'] + $pixelRgba['blue']) / 3;

        return floor($invertedShade / self::COLOR_DIVIDER);
    }

    /**
     *
     * @param int $x
     * @param int $y
     * @return \HeightmapToVoxlap\Color
     */
    protected function getColor($x, $y)
    {
        $colorArray = imagecolorsforindex($this->scaleRessource, imagecolorat($this->scaleRessource, 0, $this->getZ($x, $y)));
        $color = new Color();
        $color->setRedValue($colorArray['red']);
        $color->setGreenValue($colorArray['green']);
        $color->setBlueValue($colorArray['blue']);

        return $color;
    }
}
