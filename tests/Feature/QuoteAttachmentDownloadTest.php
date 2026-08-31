<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\QuoteAttachment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuoteAttachmentDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_download_a_quote_attachment(): void
    {
        Storage::fake('local');

        $adminRole = Role::create(['name' => 'admin']);

        $admin = User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $lead = Lead::create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+201000000000',
            'location' => 'Cairo',
            'building_type' => 'villa',
            'area' => 250,
            'floors' => 2,
            'finishing_tier' => 'standard',
            'status' => 'new',
        ]);

        $file = UploadedFile::fake()->create('blueprint.pdf', 100, 'application/pdf');
        $path = $file->store("quotes/{$lead->id}", 'local');

        $attachment = $lead->attachments()->create([
            'original_name' => 'blueprint.pdf',
            'path' => $path,
            'mime_type' => 'application/pdf',
            'size' => $file->getSize(),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.attachments.download', $attachment))
            ->assertOk()
            ->assertDownload('blueprint.pdf');
    }

   public function test_guest_is_redirected_from_the_protected_download_route(): void
{
    $this->get('/admin/attachments/999/download')
        ->assertRedirect(route('login'));
}
}