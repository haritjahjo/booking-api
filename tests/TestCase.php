<?php

namespace Tests;

use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
 
        $this->seed(); // THIS IS THE LINE WE NEED
    }
}
