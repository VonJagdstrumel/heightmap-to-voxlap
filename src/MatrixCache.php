<?php

namespace HeightmapToVoxlap;

/**
 *
 */
class MatrixCache
{
    protected $length;
    protected $defaultCount;
    protected $spanVector;
    protected $countVector;

    public function __construct($length)
    {
        // TODO: Test arguments
        $this->length = $length;
        $this->spanVector = new \SplFixedArray(pow($length, 2));
        $this->countVector = new \SplFixedArray(pow($length, 2));
    }

    public function setSpan($x, $y, Span $span, $count)
    {
        // TODO: Check arguments
        $offset = $this->toVectorOffset($x, $y);
        $this->spanVector[$offset] = $span;
        $this->countVector[$offset] = $count;
    }

    public function getSpan($x, $y)
    {
        // TODO: Check arguments
        if (!$this->hasSpan($x, $y)) {
            throw new \RuntimeException('No span defined at these coordinates.');
        }

        $span = $this->spanVector[$this->toVectorOffset($x, $y)];
        $this->decrementCount($x, $y);
        return $span;
    }

    public function hasSpan($x, $y)
    {
        // TODO: Check arguments
        return !is_null($this->countVector[$this->toVectorOffset($x, $y)]);
    }

    protected function removeSpan($x, $y)
    {
        // TODO: Check arguments
        if (!$this->hasSpan($x, $y)) {
            throw new \RuntimeException('No span defined at these coordinates.');
        }

        $offset = $this->toVectorOffset($x, $y);
        unset($this->spanVector[$offset]);
        unset($this->countVector[$offset]);
    }

    protected function decrementCount($x, $y)
    {
        // TODO: Check arguments
        if (!$this->hasSpan($x, $y)) {
            throw new \RuntimeException('No span defined at these coordinates.');
        }

        $offset = $this->toVectorOffset($x, $y);
        $this->countVector[$offset] -= 1;

        if (!$this->countVector[$offset]) {
            $this->removeSpan($x, $y);
        }
    }

    protected function toVectorOffset($x, $y)
    {
        // TODO: Check arguments
        return $y * $this->length + $x;
    }

    public function printDebug()
    {
        $print = '';
        for ($y = 0; $y < $this->length; ++$y) {
            for ($x = 0; $x < $this->length; ++$x) {
                $offset = $this->toVectorOffset($x, $y);
                $print .= (($this->countVector[$offset] !== null) ? $this->countVector[$offset] : 'x') . "\t";
            }
            $print .= PHP_EOL;
        }
        print $print;
    }
}
