<?php

namespace App\Http\Requests;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Reservation;
use App\Mail\PaymentNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
        return [
            'particular' => 'required',
            'receipt_no' => 'required',
            'expense' => 'required',
            'amount' => 'required',
            'amount' => 'required',
            'image' => 'required',
            'date' => 'required',
        ];
    }

    public function save()
    {
        $amount = (int) json_decode($this->amount);

        $data = $this->all();
        $data['particular'] = strtoupper($data['particular']);

        switch ($data['expense']) {
            case 'AGENTS COMMISSION SAN VICENTE':
                $data['agents_commission_san_vicente'] = $data['amount'];
                break;
            case 'AGENTS COMMISSION TINIWISAN':
                $data['agents_commission_tiniwisan'] = $data['amount'];
                break;
            case 'SALARY':
                $data['salary'] = $data['amount'];
                break;
            case 'OFFICE RENTAL EXPENSE':
                $data['office_rental_expense'] = $data['amount'];
                break;
            case 'UTILITY EXPENSE':
                $data['utility_expense'] = $data['amount'];
                break;
            case 'FUEL & GASOLINE':
                $data['fuel_gasoline'] = $data['amount'];
                break;
            case 'OFFICE/MATERIALS & SUPPLIES':
                $data['office_materials'] = $data['amount'];
                break;
            case 'REPAIR & MAINTENANCE':
                $data['repair_maintenance'] = $data['amount'];
                break;
            case 'REPRESENTATION EXPENSE':
                $data['representation_expense'] = $data['amount'];
                break;
            case 'TRANSPORTATION EXPENSE':
                $data['transportation'] = $data['amount'];
                break;
            case "RETAINER'S FEE":
                $data['retainers'] = $data['amount'];
                break;
            case 'LOT CANCELLATION':
                $data['lot_cancellation'] = $data['amount'];
                break;
            case 'WEB SYSTEM DEVELOPMENT':
                $data['web_system_development'] = $data['amount'];
                break;
            case 'PROFESSIONAL FEE':
                $data['professional_fee'] = $data['amount'];
                break;
            case 'PROCESSING FEE':
                $data['processing_fee'] = $data['amount'];
                break;
            case 'EQUIPMENT':
                $data['equipment'] = $data['amount'];
                break;
            case 'OTHERS':
                $data['others'] = $data['amount'];
                break;
        }

        $expense = Expense::create($data);

        if ($this->hasFile('image')) {
            $file = $this->file('image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('expenses/' . $expense->id, $filename, 's3');

            $expense->update([
                'image' => $filename
            ]);
        }

        // Mail::to($this->buyer->email)->send(new PaymentNotification());

        // Mail::to("k.monteadora@gmail.com")->send(new PaymentNotification());

        return $expense;
    }
}
