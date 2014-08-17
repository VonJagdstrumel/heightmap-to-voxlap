<?php

namespace HeightmapToVoxlap;

use UtilLib;

/**
 *
 */
class Span
{
    const MIN_Z_VALUE = 0;
    const MAX_Z_VALUE = 63;
    const COLOR_ALPHA = 128;
    const COLOR_RANDOM_VARIATION = 2;
    const COLOR_SHADOW_VARIATION = 16;
    const PACK_CHAR_FORMAT = 'C';

    protected $adjacent;
    protected $z;
    protected $color;

    /**
     *
     * @param int $z
     * @param Color $spanColor
     */
    public function __construct($z, Color $spanColor)
    {
        Misc::checkRange($z, self::MIN_Z_VALUE, self::MAX_Z_VALUE);

        $this->adjacent = new AdjacentSpanMap();
        $this->z = $z;
        $this->color = $spanColor;
    }

    /**
     *
     * @return int
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     *
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     *
     * @param int $z
     */
    public function setZ($z)
    {
        Misc::checkRange($z, self::MIN_Z_VALUE, self::MAX_Z_VALUE);

        $this->z = $z;
    }

    /**
     *
     * @param Color $color
     */
    public function setColor(Color $color)
    {
        $this->color = $color;
    }

    /**
     *
     * @param string $direction
     * @param Span $span
     */
    public function setAdjacentSpan($direction, $span)
    {
        $this->adjacent->setSpanByDirection($direction, $span);
    }

    /**
     *
     * @return int
     */
    public function hasShadow()
    {
        return ($this->adjacent->getWestSpan()->getZ() < $this->z) ? 1 : 0;
    }

    /**
     *
     * @return int
     */
    public function maxGap()
    {
        $maxGap = 0;

        foreach ($this->adjacent->toArray() as $span) {
            if ($span->getZ() > $this->z + $maxGap + 1) {
                $maxGap = $span->getZ() - $this->z - 1;
            }
        }

        return $maxGap;
    }

    /**
     *
     * @return string
     */
    public function toBinary()
    {
        $gap = $this->maxGap();
        $data = '';

        $data .= pack(self::PACK_CHAR_FORMAT, 0);
        $data .= pack(self::PACK_CHAR_FORMAT, $this->z);
        $data .= pack(self::PACK_CHAR_FORMAT, $this->z + $gap);
        $data .= pack(self::PACK_CHAR_FORMAT, 0);

        for ($i = 0; $i <= $gap; ++$i) {
            $data .= pack(self::PACK_CHAR_FORMAT, $this->color->getBlueValue() + $this->randomColorVariation() - $this->shadowVariation());
            $data .= pack(self::PACK_CHAR_FORMAT, $this->color->getGreenValue() + $this->randomColorVariation() - $this->shadowVariation());
            $data .= pack(self::PACK_CHAR_FORMAT, $this->color->getRedValue() + $this->randomColorVariation() - $this->shadowVariation());
            $data .= pack(self::PACK_CHAR_FORMAT, self::COLOR_ALPHA);
        }

        return $data;
    }

    /**
     *
     * @return int
     */
    protected function randomColorVariation()
    {
        return mt_rand(-self::COLOR_RANDOM_VARIATION, self::COLOR_RANDOM_VARIATION);
    }

    /**
     *
     * @return int
     */
    protected function shadowVariation()
    {
        return $this->hasShadow() * self::COLOR_SHADOW_VARIATION;
    }
}
