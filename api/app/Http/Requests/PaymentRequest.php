<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    protected $buyer;
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
        $data = [];

        foreach ($this->all() as $key => $value) {
            $data[$key] = json_decode($value);
        }

        $this->merge($data);

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
            'reservation_id' => 'required',
            'buyer_id' => 'required',
            'paid_at' => 'required',
            'ar_number' => 'required',
            'amount' => 'required',
            'type_of_payment' => 'required',
            'mode_of_payment' => 'required',
        ];
    }

    public function save()
    {
        $this->buyer = User::where('role_id', 5)->find($this->buyer_id);

        if (!$this->buyer) {
            abort(403, 'Not authorized');
        }

        $payment = Payment::create($this->all());

        if ($this->hasFile($this->image)) {
            $path = 'payments/' . $buyer->id;

            Storage::disk('local')->put($path, $this->file($this->image));
            $payment->update(['image' => $path]);
        }

        return $payment;
    }
}
