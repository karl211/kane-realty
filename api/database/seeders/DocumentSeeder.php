<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            [
                'title' => 'post_dated_cheque',
                'desc' => 'Post Dated Cheque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'birth_or_marriage_certificate',
                'desc' => 'Photocopy of Marriage Certificate/Birth Certificate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'picture_by_2',
                'desc' => '2 pcs 2x2 picture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'tax_certificate',
                'desc' => 'Community Tax Certificate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'proof_of_billing',
                'desc' => 'Proof of Billing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'valid_id',
                'desc' => "2 Valid ID's (Company and Government)",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'tin',
                'desc' => 'Tax Identification Number',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'house_sketch',
                'desc' => 'House Sketch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'picture_by_1',
                'desc' => '3 pcs 1x1 picture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'spa',
                'desc' => 'SPA (with Consular Seal if notarized abroad)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        Document::insert($documents);
    }
}
