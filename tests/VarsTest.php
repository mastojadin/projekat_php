<?php

use PHPUnit\Framework\TestCase;

use App\config\Vars;

final class VarsTest extends TestCase {
    // is this ok
    // or this should be three tests
    public function test_get_back_value() :void
    {
        $this->assertIsBool(Vars::get_me('api_actions'));
        $this->assertIsArray(Vars::get_me('api_s.actions'));
        $this->assertIsString(Vars::get_me('db.username'));
    }
}
