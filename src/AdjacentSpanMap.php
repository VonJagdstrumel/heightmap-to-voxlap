<?php

namespace HeightmapToVoxlap;

/**
 *
 */
class AdjacentSpanMap
{
    protected $westSpan;
    protected $eastSpan;
    protected $northSpan;
    protected $southSpan;

    /**
     *
     */
    public function __construct()
    {
        $this->westSpan = null;
        $this->eastSpan = null;
        $this->northSpan = null;
        $this->southSpan = null;
    }

    /**
     *
     * @return \HeightmapToVoxlap\Span
     */
    public function getWestSpan()
    {
        return $this->westSpan;
    }

    /**
     *
     * @return \HeightmapToVoxlap\Span
     */
    public function getEastSpan()
    {
        return $this->eastSpan;
    }

    /**
     *
     * @return \HeightmapToVoxlap\Span
     */
    public function getNorthSpan()
    {
        return $this->northSpan;
    }

    /**
     *
     * @return \HeightmapToVoxlap\Span
     */
    public function getSouthSpan()
    {
        return $this->southSpan;
    }

    /**
     *
     * @param string $direction
     * @return \HeightmapToVoxlap\Span
     */
    public function getSpanByDirection($direction)
    {
        return $this->{"{$direction}Span"};
    }

    /**
     *
     * @param \HeightmapToVoxlap\Span $span
     */
    public function setWestSpan(Span $span)
    {
        $this->westSpan = $span;
    }

    /**
     *
     * @param \HeightmapToVoxlap\Span $span
     */
    public function setEastSpan(Span $span)
    {
        $this->eastSpan = $span;
    }

    /**
     *
     * @param \HeightmapToVoxlap\Span $span
     */
    public function setNorthSpan(Span $span)
    {
        $this->northSpan = $span;
    }

    /**
     *
     * @param \HeightmapToVoxlap\Span $span
     */
    public function setSouthSpan(Span $span)
    {
        $this->southSpan = $span;
    }

    /**
     *
     * @param string $direction
     * @param \HeightmapToVoxlap\Span $span
     */
    public function setSpanByDirection($direction, Span $span)
    {
        $this->{"{$direction}Span"} = $span;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'west' => $this->westSpan,
            'east' => $this->eastSpan,
            'north' => $this->northSpan,
            'south' => $this->southSpan
        ];
    }
}
