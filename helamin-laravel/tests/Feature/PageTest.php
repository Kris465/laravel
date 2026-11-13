<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PageSeeder::class);
    }

    public function test_home_page_is_available(): void
    {
        $this->get('/')->assertOk()->assertSee('HELAMIN');
    }

    public function test_every_active_page_is_available(): void
    {
        $slugs = Page::query()->where('is_active', true)->pluck('slug');

        $this->assertGreaterThan(15, $slugs->count());

        foreach ($slugs as $slug) {
            $url = $slug === '/' ? '/' : '/'.$slug;

            $this->get($url)->assertOk();
        }
    }

    public function test_unknown_page_returns_404(): void
    {
        $this->get('/ne-sushchestvuyushchaya-stranitsa')->assertNotFound();
    }

    public function test_inactive_page_returns_404(): void
    {
        Page::query()->where('slug', 'news')->update(['is_active' => false]);

        $this->get('/news')->assertNotFound();
    }

    public function test_removed_sections_are_not_routed(): void
    {
        $this->get('/otrasli-promyshlennosti')->assertNotFound();
        $this->get('/referentsii')->assertNotFound();
    }

    public function test_admin_panel_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_admin_user_can_open_admin_panel(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->assertDatabaseHas('users', ['email' => $user->email, 'is_admin' => 1]);

        $this->actingAs($user, 'web')->get('/admin')->assertOk();
    }
}
