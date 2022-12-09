<?php

namespace App\Http\Controllers\Api;

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
    public function index()
    {
        $sales = collect(DB::select('
        SELECT DISTINCT
            DATE_FORMAT(paid_at, "%b") AS `month`, 
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
            paid_at >= "2020-01-01" AND
            paid_at <= "2020-12-31" AND 
            locations.branch_id = 2
        GROUP BY
            month, 
            year, 
            type_of_payment
        ORDER BY
            month ASC
        '));

        // [
        //     {
        //         particular: "San Vicente",
        //         reservation: {
        //             jan: 100000,
        //             feb: 100000,
        //             mar: 100000,
        //             apr: 100000,
        //             may: 100000,
        //             june: 100000,
        //             july: 100000,
        //             aug: 150000,
        //             sept: 100000,
        //             oct: 100000,
        //             nov: 100000,
        //             dec: 100000,
        //             total: 0
        //         },
        //         amortization: {
        //             jan: 150000,
        //             feb: 100000,
        //             mar: 100000,
        //             apr: 100000,
        //             may: 100000,
        //             june: 100000,
        //             july: 100000,
        //             aug: 100000,
        //             sept: 100000,
        //             oct: 100000,
        //             nov: 100000,
        //             dec: 100000,
        //             total: 0
        //         }
        //     },
        //     {
        //         particular: "Tiniwisan",
        //         reservation: {
        //             jan: 100000,
        //             feb: 100000,
        //             mar: 100000,
        //             apr: 100000,
        //             may: 100000,
        //             june: 100000,
        //             july: 100000,
        //             aug: 150000,
        //             sept: 1003000,
        //             oct: 100000,
        //             nov: 100000,
        //             dec: 100000,
        //             total: 0
        //         },
        //         amortization: {
        //             jan: 150000,
        //             feb: 100000,
        //             mar: 100000,
        //             apr: 100000,
        //             may: 1001000,
        //             june: 100000,
        //             july: 100000,
        //             aug: 1050000,
        //             sept: 100000,
        //             oct: 100000,
        //             nov: 100000,
        //             dec: 100000,
        //             total: 0
        //         }
        //     },
        // ]

        $data = [];

        foreach ($sales as $sale) {
            $arr = [];
            $data['particular'] = $sale->location;

            if ($sale->type_of_payment == 'Reservation Fee') {
                $arr['reservation'] = [$sale->month => $sale->amount_total];
                
            } else if ($sale->type_of_payment == 'Monthly Amortization') {
                $arr['amortization'] = [$sale->month => $sale->amount_total];
            }
            
            $data[] = $arr;
            
        }
        dd($data);
        
        // ->map(function($q) {
        //     return [
        //         'particular' => $q->type_of_payment,
        //         'month' => $q->month,
        //         'total' => $q->amount_total
        //     ];
        // });

        return $sales;
        // return 'test';
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
