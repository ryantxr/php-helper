<?php
use Ryantxr\Helper\Timer;

class TimerTest extends PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function smoke()
    {
        $t = new Timer();
        $this->assertTrue(is_object($t));
    }

    /**
     * @test
     */
    public function elapsed()
    {
        $t = new Timer();
        $t->millisecondStart();
        sleep(2);
        $elapsed = $t->millisecondElapsed();
        // echo 'ELAPSED ' . $elapsed . "\n";
        $this->assertTrue($elapsed >= 2000);
    }
}