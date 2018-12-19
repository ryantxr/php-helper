<?php namespace Ryantxr\Helper;

/**
 * A class that provides elapsed time in milliseconds. For use when needing to measure
 * less than a second.
 * This cannot be used to measure long periods of time like years. The most it can
 * be used for is 9999999 seconds. After that, it wraps and starts over.
 */
class Timer
{
    protected $msecs;
    public function millisecondStart()
    {
        $this->msecs = $this->mtime();
        // echo "INIT {$this->msecs}\n";
        return $this->msecs;
    }

    public function millisecondElapsed()
    {
        $newtime = $this->mtime();
        $elapsed = ( $newtime >= $this->msecs ) ? $newtime - $this->msecs : (9999999999 - $this->msecs) + $newtime ;
        return $elapsed;
    }

    protected function mtime()
    {
        list($m, $s) = explode(' ', microtime());
        $msecs = substr($s, -7) . substr($m, 2, 3);
        return $msecs;
    }
}