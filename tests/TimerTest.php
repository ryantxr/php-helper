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

    /**
     * @test
     * Ensures that there is a minimum time for each iteration.
     */
    public function velocity()
    {
        $t = new Timer();
        echo "\n";
        for ( $i=0; $i<5; $i++ ) {
            $t->millisecondStart();

            usleep(mt_rand(900, 9999));

            $elapsed = $t->millisecondElapsed();
            if ( $elapsed < 1000 ) {
                usleep((1000-$elapsed)*1000);
            }
            $trueElapsed = $t->millisecondElapsed();

            echo "$i " . $elapsed . ' ' . $trueElapsed . "\n";
            $this->assertTrue($trueElapsed >= 1000);
        }
    }
}