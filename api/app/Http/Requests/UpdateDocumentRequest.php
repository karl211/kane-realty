<?php

namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    public function sanitize()
    {
        $this->merge([
            'documents' => json_decode($this->input('documents'), true),
        ]);
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'valid_id' => 'required|max:1000',
        ];
    }

    public function save($buyer)
    {
        
        $documents = Document::all();
        
        foreach ($documents as $document) {
            $db_document = $buyer->documents()->newPivotQuery()
                    ->where([
                        'buyer_id' => $buyer->id,
                        'document_id' => $document->id
                    ])
                    ->first();

            if ($db_document && $this[$document->title] == 'null') {
                abort_if(! auth()->user()->hasPermissionTo('document_delete'), 403, 'Remove document is unauthorized');

                Storage::disk('s3')->delete('buyers/' . $buyer->id . '/' . $document->title . '/' . $db_document->file);

                $buyer->documents()->newPivotQuery()
                    ->where([
                        'buyer_id' => $buyer->id,
                        'document_id' => $document->id
                    ])
                    ->delete();
            }
            else if ($this->hasFile($document->title)) {
                abort_if(! auth()->user()->hasPermissionTo('document_edit'), 403, 'This action is unauthorized');

                if ($db_document && $db_document->file) {
                    Storage::disk('s3')->delete('buyers/' . $buyer->id . '/' . $document->title . '/' . $db_document->file);
                }

                $file = $this->file($document->title);
                
                $filename = $file->getClientOriginalName();
                $file->storeAs('buyers/' . $buyer->id . '/' . $document->title, $filename, 's3');


                $buyer->documents()->newPivotQuery()->updateOrInsert([
                    'buyer_id' => $buyer->id,
                    'document_id' => $document->id
                ], [
                    'file' => $filename,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
