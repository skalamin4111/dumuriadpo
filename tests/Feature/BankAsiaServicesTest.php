<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BankAsiaAcCreation;
use App\Models\BankAsiaShonchoyPotro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BankAsiaServicesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::create([
            'name' => 'Test CSO',
            'email' => 'cso@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
    }

    /**
     * Account Creations Tests
     */
    public function test_account_creation_index_page_loads_for_authenticated_users(): void
    {
        $this->actingAs($this->user)
            ->get(route('bank-asia.ac-creations.index'))
            ->assertOk()
            ->assertViewIs('services.bank-asia.ac-creations.index');
    }

    public function test_account_creation_create_page_loads(): void
    {
        $this->actingAs($this->user)
            ->get(route('bank-asia.ac-creations.create'))
            ->assertOk()
            ->assertViewIs('services.bank-asia.ac-creations.create');
    }

    public function test_can_store_account_creation_record(): void
    {
        Storage::fake('public');

        $signature = UploadedFile::fake()->image('signature.png');

        $data = [
            'date' => '2026-07-05',
            'account_type' => 'new',
            'applicant_name_bn' => 'সাহিল ইসলাম',
            'father_name' => 'Abul Kashem',
            'mother_name' => 'Sufia Begum',
            'nid_number' => '1234567890123',
            'occupation' => 'Businessman',
            'monthly_income' => 50000.00,
            'source_of_funds' => 'Business',
            'present_address' => 'Dumuria, Khulna',
            'mobile_number' => '01711122233',
            'outlet_name_address' => 'Dumuria DPO, Khulna',
            'status' => 'pending',
            'applicant_signature' => $signature,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('bank-asia.ac-creations.store'), $data);

        $ac = BankAsiaAcCreation::first();
        $response->assertRedirect(route('bank-asia.ac-creations.show', $ac));
        
        $this->assertDatabaseHas('bank_asia_ac_creations', [
            'applicant_name_bn' => 'সাহিল ইসলাম',
            'nid_number' => '1234567890123',
        ]);

        $ac = BankAsiaAcCreation::first();
        $this->assertNotNull($ac->applicant_signature_path);

        Storage::disk('public')->assertExists($ac->applicant_signature_path);
    }

    public function test_can_update_account_creation_record(): void
    {
        $ac = BankAsiaAcCreation::create([
            'date' => '2026-07-05',
            'account_type' => 'new',
            'applicant_name_bn' => 'সাহিল ইসলাম',
            'father_name' => 'Abul Kashem',
            'mother_name' => 'Sufia Begum',
            'nid_number' => '1234567890123',
            'occupation' => 'Businessman',
            'monthly_income' => 50000.00,
            'source_of_funds' => 'Business',
            'present_address' => 'Dumuria, Khulna',
            'mobile_number' => '01711122233',
            'outlet_name_address' => 'Dumuria DPO, Khulna',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('bank-asia.ac-creations.update', $ac), [
                'date' => '2026-07-05',
                'account_type' => 'dormant',
                'applicant_name_bn' => 'সাহিল ইসলাম আপডেট',
                'father_name' => 'Abul Kashem',
                'mother_name' => 'Sufia Begum',
                'nid_number' => '1234567890123',
                'occupation' => 'Businessman',
                'monthly_income' => 60000.00,
                'source_of_funds' => 'Business',
                'present_address' => 'Dumuria, Khulna',
                'mobile_number' => '01711122233',
                'outlet_name_address' => 'Dumuria DPO, Khulna',
                'status' => 'approved',
            ]);

        $response->assertRedirect(route('bank-asia.ac-creations.show', $ac));
        $this->assertDatabaseHas('bank_asia_ac_creations', [
            'id' => $ac->id,
            'applicant_name_bn' => 'সাহিল ইসলাম আপডেট',
            'status' => 'approved',
            'account_type' => 'dormant',
        ]);
    }

    /**
     * Savings Certificates (Shonchoy Potro) Tests
     */
    public function test_shonchoy_potro_index_loads_for_authenticated_users(): void
    {
        $this->actingAs($this->user)
            ->get(route('bank-asia.shonchoy-potros.index'))
            ->assertOk()
            ->assertViewIs('services.bank-asia.shonchoy-potros.index');
    }

    public function test_can_store_shonchoy_potro_record(): void
    {
        Storage::fake('public');
        $pdfDoc = UploadedFile::fake()->create('certificate.pdf', 500, 'application/pdf');

        $data = [
            'purchaser_name' => 'Shonchoy Customer',
            'purchaser_nid' => '9876543210123',
            'purchaser_phone' => '01799887766',
            'purchaser_dob' => '1980-05-20',
            'purchaser_address' => 'Dumuria, Khulna',
            'certificate_type' => 'family',
            'certificate_number' => 'SP-998811',
            'registration_number' => 'REG-112233',
            'purchase_date' => '2026-07-01',
            'maturity_date' => '2031-07-01',
            'purchase_amount' => 500000.00,
            'interest_rate' => 11.52,
            'nominee_name' => 'Nominee One',
            'nominee_relation' => 'Son',
            'nominee_share_percent' => 100,
            'status' => 'active',
            'document' => $pdfDoc,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('bank-asia.shonchoy-potros.store'), $data);

        $potro = BankAsiaShonchoyPotro::first();
        $response->assertRedirect(route('bank-asia.shonchoy-potros.show', $potro));
        
        $this->assertDatabaseHas('bank_asia_shonchoy_potros', [
            'purchaser_name' => 'Shonchoy Customer',
            'certificate_number' => 'SP-998811',
        ]);

        $potro = BankAsiaShonchoyPotro::first();
        $this->assertNotNull($potro->document_path);
        Storage::disk('public')->assertExists($potro->document_path);
    }
}
