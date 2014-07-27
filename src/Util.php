<?php

namespace HeightmapToVoxlap;

/**
 *
 */
class Util
{

    /**
     *
     * @param array $array
     * @return \SplQueue
     */
    public static function arrayToQueue(array $array)
    {
        $queue = new \SplQueue();

        while (!empty($array)) {
            $queue->unshift(array_pop($array));
        }

        return $queue;
    }

    /**
     *
     * @param \SplQueue $queue
     * @return array
     */
    public static function queueToArray(\SplQueue $queue)
    {
        $array = [];

        while (!$queue->isEmpty()) {
            $array[] = $queue->dequeue();
        }

        return $array;
    }

    /**
     *
     * @param int $dividend
     * @param int $divisor
     * @return int
     */
    public static function modulo($dividend, $divisor)
    {
        // TODO: Test arguments
        return ($divisor + ($dividend % $divisor)) % $divisor;
    }

    /**
     *
     * @param mixed $done
     * @param mixed $total
     * @param resource $destination
     * @throws \RuntimeException
     */
    public static function printProgress($done, $total, $destination = STDOUT)
    {
        // TODO: Test arguments
        if ($done > $total) {
            throw new \RuntimeException('$done is greater than $total.');
        }

        if (get_resource_type($destination) != 'stream') {
            throw new \RuntimeException('$destination is not a stream resource.');
        }

        $disp = floor(($done / $total) * 100);
        fwrite($destination, "\r" . $disp . "%");
    }

    /**
     *
     * @param string $message
     * @param resource $destination
     * @throws \RuntimeException
     */
    public static function printException($message, $destination = STDERR)
    {
        if (get_resource_type($destination) != 'stream') {
            throw new \RuntimeException('$destination is not a stream resource.');
        }

        fwrite($destination, "$message\n");
    }

    /**
     *
     * @param int $value
     * @param int $minVal
     * @param int $maxVal
     * @throws \Exception
     */
    public static function checkRange($value, $minVal, $maxVal)
    {
        $isValid = filter_var($value, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => $minVal,
                'max_range' => $maxVal
            )
        ));

        if ($isValid === false) {
            throw new \RuntimeException('Value is not in range.');
        }
    }
}
