<?php

namespace Tests\Feature;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Media;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function test_content_is_sanitized(): void
    {
        Page::query()->where('slug', 'news')->update([
            'content' => "# Новости\n\n<script>alert('xss')</script>\n\n[Опасная ссылка](javascript:alert(1))",
        ]);

        $response = $this->get('/news')->assertOk();

        $response->assertSee('<h1>Новости</h1>', false);
        $response->assertDontSee('<script>', false);
        $response->assertDontSee('javascript:', false);
    }

    public function test_favicon_is_linked(): void
    {
        // Иконка встроена data-URI: хостинг не отдаёт .svg как статику.
        $this->get('/')
            ->assertOk()
            ->assertSee('rel="icon"', false)
            ->assertSee('data:image/svg+xml', false)
            ->assertSee('image/svg+xml', false)
            ->assertSee('%23e92627', false);
    }

    public function test_public_pages_send_security_headers(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertHeader('Content-Security-Policy')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_no_automatic_media_block_is_rendered(): void
    {
        Page::query()->where('slug', 'biblioteka')->update([
            'images' => ['images/produkt.jpg'],
            'documents' => ['documents/passport.pdf'],
        ]);

        $this->get('/biblioteka')
            ->assertOk()
            ->assertDontSee('page-gallery', false)
            ->assertDontSee('page-documents', false)
            ->assertDontSee('/storage/images/produkt.jpg', false)
            ->assertDontSee('/storage/documents/passport.pdf', false);

        // Ни на главной, ни на любой другой странице блока под текстом нет.
        $this->get('/')->assertOk()->assertDontSee('page-gallery', false);
    }

    public function test_media_names_with_spaces_are_escaped(): void
    {
        $url = Page::mediaUrl('images/Мой файл 1.jpg');

        $this->assertStringNotContainsString(' ', $url);
        $this->assertStringContainsString('%20', $url);

        Page::query()->where('slug', 'biblioteka')->update([
            'images' => ['images/Мой файл 1.jpg'],
            'documents' => ['documents/my document.pdf'],
        ]);

        $this->get('/biblioteka')
            ->assertOk()
            ->assertDontSee('src="/storage/images/Мой файл 1.jpg"', false);
    }

    public function test_images_can_be_inserted_into_markdown_text(): void
    {
        Page::query()->where('slug', 'news')->update([
            'content' => "# Новости\n\n![Фото котла](/storage/images/kotel.jpg)",
        ]);

        $this->get('/news')
            ->assertOk()
            ->assertSee('<img', false)
            ->assertSee('/storage/images/kotel.jpg', false)
            ->assertSee('alt="Фото котла"', false);
    }

    public function test_background_from_admin_is_applied(): void
    {
        Page::query()->where('slug', '/')->update(['background' => 'backgrounds/water tile.jpg']);

        $this->get('/news')
            ->assertOk()
            ->assertSee('has-site-background', false)
            ->assertSee('/storage/backgrounds/water%20tile.jpg', false);
    }

    public function test_background_is_not_applied_when_not_set(): void
    {
        $this->get('/news')->assertOk()->assertDontSee('has-site-background', false);
    }

    public function test_background_field_is_available_on_home_page(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $home = Page::query()->where('slug', '/')->firstOrFail();

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$home->id.'/edit')
            ->assertOk()
            ->assertSee('Фон сайта', false);
    }

    public function test_content_form_renders_in_admin(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$page->id.'/edit')
            ->assertOk()
            ->assertSee('Текст страницы', false)
            ->assertDontSee('Фон сайта', false)
            ->assertDontSee('Delete', false)
            ->assertSee('--cols-lg: repeat(3', false)
            ->assertSee('--col-span-lg: span 2 / span 2', false)
            ->assertSee('--cols-lg: repeat(1', false);
    }

    public function test_pages_cannot_be_created_or_deleted_via_resource(): void
    {
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        $this->assertFalse(PageResource::canCreate());
        $this->assertFalse(PageResource::canDelete($page));
        $this->assertFalse(PageResource::canDeleteAny());
    }

    public function test_home_page_cannot_be_deleted(): void
    {
        $home = Page::query()->where('slug', '/')->firstOrFail();

        $this->assertFalse($home->delete());
        $this->assertDatabaseHas('pages', ['slug' => '/']);
    }

    public function test_managers_cannot_create_pages(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->actingAs($user, 'web')->get('/admin/pages/create')->assertNotFound();
    }

    public function test_admin_user_can_open_admin_panel(): void
    {
        $user = User::factory()->create(['is_admin' => true]);

        $this->assertDatabaseHas('users', ['email' => $user->email, 'is_admin' => 1]);

        $this->actingAs($user, 'web')->get('/admin')->assertOk();
    }

    public function test_media_links_survive_file_rename(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('images/kotel-01_renamed.jpg', 'IMAGE-BYTES');

        $page = Page::query()->where('slug', 'news')->firstOrFail();

        $media = Media::create([
            'page_id' => $page->id,
            'disk' => 'public',
            'path' => 'images/kotel.jpg',
            'file_path' => 'images/kotel.jpg',
            'collection' => 'image',
            'label' => 'Фото котла',
        ]);

        // Типичный текст, набранный менеджером до появления медиатеки.
        $page->update(['content' => "# Новости\n\n![Фото котла](/storage/images/kotel.jpg)"]);

        $this->get('/news')
            ->assertOk()
            ->assertSee('/media/'.$media->id, false)
            ->assertDontSee('/storage/images/kotel.jpg', false);

        // Хостинг «переименовал» файл. Правится ТОЛЬКО file_path: якорь path
        // и все ссылки в тексте остаются прежними, файл отдаётся напрямую.
        $media->update(['file_path' => 'images/kotel-01_renamed.jpg']);

        $this->get('/news')->assertOk()->assertSee('/media/'.$media->id, false);
        $this->get('/media/'.$media->id)->assertOk();
        $this->assertSame('IMAGE-BYTES', $this->get('/media/'.$media->id)->streamedContent());
    }

    public function test_inserted_document_becomes_inline_preview(): void
    {
        $page = Page::query()->where('slug', 'biblioteka')->firstOrFail();

        $document = Media::create([
            'page_id' => $page->id,
            'disk' => 'public',
            'path' => 'documents/passport.pdf',
            'collection' => 'document',
            'label' => 'Паспорт безопасности',
        ]);

        $page->update([
            'documents' => ['documents/passport.pdf'],
            'content' => 'Скачайте [Паспорт безопасности](/media/'.$document->id.')',
        ]);

        $this->get('/biblioteka')
            ->assertOk()
            ->assertSee('pdf-card--inline', false)         // превью вместо ссылки
            ->assertSee('/media/'.$document->id, false)
            ->assertSee('Паспорт безопасности', false)
            ->assertDontSee('page-gallery', false)         // авто-блоков больше нет
            ->assertDontSee('page-documents', false);
    }

    public function test_media_sync_registers_existing_uploads(): void
    {
        Page::query()->where('slug', 'biblioteka')->update([
            'images' => ['images/old-photo.jpg'],
            'documents' => ['documents/old-passport.pdf'],
        ]);

        $this->artisan('media:sync')->assertSuccessful();

        $this->assertDatabaseHas('media', ['path' => 'images/old-photo.jpg', 'collection' => 'image']);
        $this->assertDatabaseHas('media', ['path' => 'documents/old-passport.pdf', 'collection' => 'document']);
    }

    public function test_media_library_is_available_in_admin(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('documents/passport.pdf', '%PDF-1.4');

        $user = User::factory()->create(['is_admin' => true]);
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        $media = Media::create([
            'page_id' => $page->id,
            'disk' => 'public',
            'path' => 'documents/passport.pdf',
            'file_path' => 'documents/passport.pdf',
            'collection' => 'document',
            'label' => 'Паспорт безопасности',
        ]);

        $this->actingAs($user, 'web')
            ->get('/admin/media')
            ->assertOk()
            ->assertSee('Медиатека', false)
            ->assertSee('Паспорт безопасности', false);

        $this->actingAs($user, 'web')
            ->get('/admin/media/'.$media->id.'/edit')
            ->assertOk()
            ->assertSee('Фактический путь файла', false);
    }

    public function test_insert_buttons_are_shown_in_edit_form(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('documents/passport.pdf', '%PDF-1.4');

        $user = User::factory()->create(['is_admin' => true]);
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        Media::create([
            'page_id' => $page->id,
            'disk' => 'public',
            'path' => 'documents/passport.pdf',
            'file_path' => 'documents/passport.pdf',
            'collection' => 'document',
            'label' => 'Паспорт безопасности',
        ]);

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$page->id.'/edit')
            ->assertOk()
            ->assertSee('Вставить файл в текст', false)
            ->assertSee('Паспорт безопасности', false);
    }

    public function test_media_route_serves_file_inline_and_allows_iframes(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('images/photo.jpg', 'IMAGE-BYTES');

        $media = Media::create([
            'disk' => 'public',
            'path' => 'images/photo.jpg',
            'file_path' => 'images/photo.jpg',
            'collection' => 'image',
        ]);

        $response = $this->get('/media/'.$media->id)->assertOk();

        // PDF-превью встраиваются в <iframe>: запрещающих заголовков быть не должно.
        $this->assertFalse($response->baseResponse->headers->has('X-Frame-Options'));
        $this->assertFalse($response->baseResponse->headers->has('Content-Security-Policy'));
        $this->assertSame('IMAGE-BYTES', $response->streamedContent());
    }

    public function test_media_controller_sets_explicit_mime_by_extension(): void
    {
        Storage::fake('public');

        // fileinfo на Windows/некоторых хостингах определяет WebP/AVIF как
        // application/octet-stream — браузер тогда не показывает <img>.
        $cases = [
            'photo.jpg' => 'image/jpeg',
            'photo.png' => 'image/png',
            'photo.webp' => 'image/webp',
            'photo.gif' => 'image/gif',
            'photo.avif' => 'image/avif',
            'doc.pdf' => 'application/pdf',
        ];

        foreach ($cases as $name => $mime) {
            Storage::disk('public')->put('images/'.$name, 'BYTES');

            $media = Media::create([
                'disk' => 'public',
                'path' => 'images/'.$name,
                'file_path' => 'images/'.$name,
                'collection' => str_ends_with($name, '.pdf') ? 'document' : 'image',
            ]);

            $this->get('/media/'.$media->id)
                ->assertOk()
                ->assertHeader('Content-Type', $mime);
        }
    }

    public function test_media_check_command_runs(): void
    {
        $this->artisan('media:check')->assertSuccessful();
    }

    public function test_media_route_reports_missing_file(): void
    {
        Storage::fake('public');

        $media = Media::create([
            'disk' => 'public',
            'path' => 'images/gone.jpg',
            'file_path' => 'images/gone.jpg',
            'collection' => 'image',
        ]);

        $this->get('/media/'.$media->id)->assertNotFound();
    }

    public function test_renamed_file_is_found_automatically(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('images/01M7B72_1.jpg', 'RENAMED-BYTES');

        $media = Media::create([
            'disk' => 'public',
            'path' => 'images/01M7B72.jpg',
            'file_path' => 'images/01M7B72.jpg',
            'collection' => 'image',
        ]);

        $this->get('/media/'.$media->id)->assertOk();
        $this->assertSame('images/01M7B72_1.jpg', $media->fresh()->file_path);
    }

    public function test_document_previews_and_lightbox_are_rendered(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('documents/passport.pdf', '%PDF-1.4');

        $page = Page::query()->where('slug', 'biblioteka')->firstOrFail();

        $media = Media::create([
            'page_id' => $page->id,
            'disk' => 'public',
            'path' => 'documents/passport.pdf',
            'file_path' => 'documents/passport.pdf',
            'collection' => 'document',
            'label' => 'Паспорт безопасности',
        ]);

        $page->update([
            'documents' => ['documents/passport.pdf'],
            'content' => 'Документ: [Паспорт безопасности](/media/'.$media->id.')',
        ]);

        $this->get('/biblioteka')
            ->assertOk()
            ->assertSee('pdf-card', false)
            ->assertSee('pdf-card__preview', false)
            ->assertSee('pdfLightbox', false)
            ->assertSee('/media/'.$media->id, false)
            ->assertSee('Паспорт безопасности', false)
            ->assertDontSee('page-documents', false);
    }

    public function test_pdf_lightbox_markup_is_always_available(): void
    {
        // Просмотрщик лежит в layout: превью может появиться в тексте любой страницы.
        $this->get('/news')->assertOk()->assertSee('id="pdfLightbox"', false);
    }

    public function test_news_feed_repeater_is_available_only_on_news_page(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $news = Page::query()->where('slug', 'news')->firstOrFail();
        $other = Page::query()->where('slug', 'o-produkte')->firstOrFail();

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$news->id.'/edit')
            ->assertOk()
            ->assertSee('Лента новостей', false)
            ->assertSee('Добавить новость', false);

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$other->id.'/edit')
            ->assertOk()
            ->assertDontSee('Лента новостей', false);
    }

    public function test_news_feed_blocks_are_rendered(): void
    {
        Page::query()->where('slug', 'news')->update([
            'blocks' => [
                [
                    'date' => '24.11.2026',
                    'title' => 'Новая партия реагента',
                    'text' => 'Текст новости **жирным**.',
                    'image' => 'news/photo.jpg',
                    'link' => '/o-produkte',
                ],
                // Пустой блок не должен порождать пустую карточку.
                ['date' => '', 'title' => '', 'text' => '', 'image' => '', 'link' => ''],
            ],
        ]);

        $response = $this->get('/news')
            ->assertOk()
            ->assertSee('news-feed', false)
            ->assertSee('Новая партия реагента', false)
            ->assertSee('24.11.2026', false)
            ->assertSee('<strong>жирным</strong>', false)
            ->assertSee('/storage/news/photo.jpg', false)
            ->assertSee('Подробнее', false);

        $this->assertSame(1, substr_count($response->getContent(), 'news-feed__item'));
    }

    public function test_news_feed_text_and_link_are_sanitized(): void
    {
        Page::query()->where('slug', 'news')->update([
            'blocks' => [[
                'title' => 'Санитизация',
                'text' => '<script>alert(1)</script> [вред](javascript:alert(1))',
                'link' => 'javascript:alert(1)',
            ]],
        ]);

        $this->get('/news')
            ->assertOk()
            ->assertDontSee('<script>', false)
            ->assertDontSee('href="javascript:', false);
    }

    public function test_feed_images_are_registered_in_media(): void
    {
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        $page->update([
            'blocks' => [['title' => 'Новость', 'image' => 'news/photo.jpg']],
        ]);

        $this->artisan('media:sync')->assertSuccessful();

        $this->assertDatabaseHas('media', [
            'path' => 'news/photo.jpg',
            'collection' => 'image',
            'page_id' => $page->id,
        ]);
    }

    public function test_view_page_works_with_legacy_string_media(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $page = Page::query()->where('slug', 'news')->firstOrFail();

        // Битые данные из старой БД: одиночная строка вместо массива.
        DB::table('pages')->where('id', $page->id)->update([
            'images' => 'images/legacy.jpg',
            'documents' => 'documents/legacy.pdf',
            'blocks' => 'not-an-array',
        ]);

        $this->actingAs($user, 'web')
            ->get('/admin/pages/'.$page->id)
            ->assertOk()
            ->assertDontSee('Картинки — готовые ссылки', false)
            ->assertDontSee('Готовые ссылки на документы', false);

        $this->get('/news')->assertOk()->assertDontSee('page-gallery', false);

        // Хелперы модели тоже не должны падать на строковых значениях.
        $page->refresh();
        $this->assertIsArray($page->imageUrls());
        $this->assertIsArray($page->documentLinks());
        $this->assertSame([], $page->feedBlocks());
        $this->assertSame(['images/legacy.jpg'], Page::ensurePathList('images/legacy.jpg'));
    }
}
