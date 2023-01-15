<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_year = Carbon::now()->year;

        if ($request->year != null) {
            $current_year = $request->year;
        }

        if ($request->branch_id) {

        }

        $from = $current_year.'-01-01';
        $to = $current_year.'-12-31';
        
        $payment_years = collect(DB::select('
            SELECT DISTINCT
                YEAR(paid_at) AS `year`
            FROM
                payments
            WHERE
                paid_at != "0000-00-00"
                ORDER BY year desc
        '));

        $sales = collect(DB::select('
            SELECT DISTINCT
                DATE_FORMAT(paid_at, "%b") AS `month`, 
                MONTH(paid_at) AS `month_num`, 
                type_of_payment, 
                YEAR(paid_at) AS `year`, 
                SUM(amount) AS amount_total, 
                locations.location
            FROM
                payments
                INNER JOIN
                reservations
                ON 
                    payments.reservation_id = reservations.id
                INNER JOIN
                properties
                ON 
                    reservations.property_id = properties.id
                INNER JOIN
                locations
                ON 
                    properties.location_id = locations.id
            WHERE
                paid_at >= ? AND
                paid_at <= ? AND 
                locations.branch_id = ?
            GROUP BY
                month, 
                year,
                type_of_payment
            ORDER BY
            location, month_num ASC
        ', [$from, $to, $request->branch_id]));

        $grouped_sales = $sales->groupBy('location')->map(function ($months) {
            return $months->groupBy('type_of_payment')->map(function ($items) {
                $data = [];
                $total = 0;

                foreach ($items as $item) {
                    $amount = (int) $item->amount_total;
                    $total += $amount;
    
                    $data[$item->month] = $amount;
                }
    
                $data['Total'] = $total;
                
                return $data;
            });
        });

        return response()->json([
            'years'  => $payment_years->pluck('year'),
            'sales' => $grouped_sales
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
