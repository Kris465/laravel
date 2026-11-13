<?php

namespace Tests\Unit;

use App\Models\Page;
use Tests\TestCase;

class PageTest extends TestCase
{
    public function test_is_active_is_cast_to_boolean(): void
    {
        $page = new Page(['title' => 'Тест', 'is_active' => 1]);

        $this->assertTrue($page->is_active);
        $this->assertSame('Тест', $page->title);
    }
}
