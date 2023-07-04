<?php

namespace App\Http\Requests;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Reservation;
use App\Mail\PaymentNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    protected $buyer;
    protected $reservation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    { 
        $this->reservation = Reservation::with('payments', 'property')->findOrFail($this->reservation_id);
        
        $total_payments = (int) $this->reservation->payments()->total();

        $this->buyer = User::whereHas('roles', function($q) {
                $q->where('name', 'buyer');
            })
            ->findOrFail($this->buyer_id);

        if ($total_payments >= $this->reservation->contract_price) {
            abort(403, 'This property is fully paid');
        }

        if (!$this->buyer) {
            abort(403, 'Not authorized');
        }

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
            $data[$key] = json_decode($value, true);
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
        if ($this->mode_of_payment != 'Cash') {
            return [
                'reservation_id' => 'required',
                'buyer_id' => 'required',
                'paid_at' => 'required',
                'ar_number' => 'required',
                'amount' => 'required',
                'type_of_payment' => 'required',
                'mode_of_payment' => 'required',
                'image' => 'required',
            ];
        }

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
        $amount = (int) json_decode($this->amount);

        $data = $this->all();

        if ($this->hasFile('image')) {
            $file = $this->file('image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('payments/' . $this->buyer->id . '/' . $this->mode_of_payment, $filename, 's3');

            $data['image'] = $filename;
        }
        
        $total_payments = (int) $this->reservation->payments()->total() + $amount;

        if ($total_payments >= $this->reservation->contract_price) {
            $this->reservation->update([
                'status' => 'Fully Paid'
            ]);

            $this->reservation->property->update([
                'status' => 'Fully Paid'
            ]);
        }

        $payment = Payment::create($data);


        // Mail::to($this->buyer->email)->send(new PaymentNotification());

        // Mail::to("k.monteadora@gmail.com")->send(new PaymentNotification());

        return $payment;
    }
}
