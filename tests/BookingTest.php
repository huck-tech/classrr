<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFixed()
    {
        echo 'test fixed' . PHP_EOL;
        $c = \App\Classroom::find(2);
        $result = $c->calcTotal('morning', '2017-06-10');
        var_dump($result);
        $this->assertTrue(true);
    }

    public function testFlexible()
    {
        echo 'test flexible' . PHP_EOL;
        $c = \App\Classroom::find(1);
        $result = $c->calcTotal('morning', '2018-01-01');
        var_dump($result);
        $this->assertTrue(true);
    }
}
