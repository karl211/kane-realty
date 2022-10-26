<?php

namespace Database\Seeders\Old;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuyerDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class="Database\\Seeders\\Old\\BuyerDocumentSeeder"

        $buyer_documents = DB::connection('mysql2')->select("
        SELECT
            DISTINCT
            clients.LastName, 
            clients.FirstName, 
            clients.MiddleName, 
            documents.Url, 
            documents.Type
        FROM
            clients
            INNER JOIN
            documents
            ON 
            clients.Id = documents.ClientId
        ");

        foreach ($buyer_documents as $buyer_document) {
            $doc_id = null;
            $profile = Profile::withoutGlobalScope('default_branch')
                ->where('first_name', ucwords($buyer_document->FirstName))
                ->where('last_name', ucwords($buyer_document->LastName))
                ->where('middle_name', ucwords($buyer_document->MiddleName))
                ->first();

            switch ($buyer_document->Type) {
                case '3 pcs 1x1 picture':
                    $doc_id = 9;
                    break;
                case 'proof of billing':
                    $doc_id = 5;
                    break;
                case '2 valid id':
                    $doc_id = 6;
                    break;
                case '2pcs 2x2 picture':
                    $doc_id = 3;
                    break;
                case 'marriage cert - birth cert':
                    $doc_id = 2;
                    break;
                case 'house sketch':
                    $doc_id = 8;
                    break;
                case 'community tax certificate':
                    $doc_id = 4;
                    break;
                case 'tin':
                    $doc_id = 7;
                    break;
                case 'spa':
                    $doc_id = 10;
                    break;
            }
           
            $profile->buyer->documents()->attach($doc_id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
