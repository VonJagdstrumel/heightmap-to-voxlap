<?php

namespace HeightmapToVoxlap;

/**
 *
 */
class Color
{
    const MIN_VALUE = 0;
    const MAX_VALUE = 255;

    protected $redValue;
    protected $greenValue;
    protected $blueValue;

    /**
     *
     */
    public function __construct()
    {
        $this->redValue = self::MIN_VALUE;
        $this->greenValue = self::MIN_VALUE;
        $this->blueValue = self::MIN_VALUE;
    }

    /**
     *
     * @return int
     */
    public function getRedValue()
    {
        return $this->redValue;
    }

    /**
     *
     * @return int
     */
    public function getGreenValue()
    {
        return $this->greenValue;
    }

    /**
     *
     * @return int
     */
    public function getBlueValue()
    {
        return $this->blueValue;
    }

    /**
     *
     * @param string $color
     * @return int
     */
    public function getValueByColor($color)
    {
        return $this->{"{$color}Value"};
    }

    /**
     *
     * @param int $value
     */
    public function setRedValue($value)
    {
        Util::checkRange($value, self::MIN_VALUE, self::MAX_VALUE);

        $this->redValue = $value;
    }

    /**
     *
     * @param int $value
     */
    public function setGreenValue($value)
    {
        Util::checkRange($value, self::MIN_VALUE, self::MAX_VALUE);

        $this->greenValue = $value;
    }

    /**
     *
     * @param int $value
     */
    public function setBlueValue($value)
    {
        Util::checkRange($value, self::MIN_VALUE, self::MAX_VALUE);

        $this->blueValue = $value;
    }

    /**
     *
     * @param string $color
     * @param int $value
     */
    public function setValueByColor($color, $value)
    {
        Util::checkRange($value, self::MIN_VALUE, self::MAX_VALUE);

        $this->{"{$color}Value"} = $value;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'red' => $this->redValue,
            'green' => $this->greenValue,
            'blue' => $this->blueValue
        ];
    }
}
