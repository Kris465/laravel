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

    public function test_media_url_encodes_each_path_segment(): void
    {
        $this->assertSame(
            '/storage/documents/my%20document.pdf',
            Page::mediaUrl('documents/my document.pdf'),
        );
        $this->assertSame(
            '/storage/images/photo%201.png',
            Page::mediaUrl('/images/photo 1.png'),
        );
        $this->assertStringNotContainsString(' ', Page::mediaUrl('documents/Мой документ.pdf'));
    }
}
