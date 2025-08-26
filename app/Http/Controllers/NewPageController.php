<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

require_once base_path('config/database.php'); // Ensure this is the correct path to your database configuration

class NewPageController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $name = $request->input('name');
        $proses = $request->input('proses');

        // Build the query with optional filters
        $query = "SELECT p.*, d.SHORTDESCRIPTION FROM PMBREAKDOWNENTRY p LEFT JOIN DEPARTMENT d ON d.CODE = p.DEPARTMENTCODE WHERE BREAKDOWNTYPE = 'SF' AND p.CODE LIKE '%BDIT%'";
        $bindings = [];

        if ($startDate && $endDate) {
            $query .= " AND DATE(IDENTIFIEDDATE) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        if ($name) {
            $query .= " AND DEFAULTASSIGNEDTOUSERID = ?";
            $bindings[] = $name;
        }

        if ($proses) {
            $query .= " AND STATUS = ?";
            $bindings[] = $proses;
        }

        $query .= " ORDER BY IDENTIFIEDDATE DESC";

        // Use query builder for pagination
        // Make sure the connection name matches your config/database.php
        $builder = DB::connection('ibmi')->table('PMBREAKDOWNENTRY as p')
            ->leftJoin('DEPARTMENT as d', 'd.CODE', '=', 'p.DEPARTMENTCODE')
            ->select('p.*', 'd.SHORTDESCRIPTION')
            ->where('BREAKDOWNTYPE', 'SF')
            ->where('p.CODE', 'like', '%BDIT%');

        if ($startDate && $endDate) {
            $builder->whereBetween('IDENTIFIEDDATE', [$startDate, $endDate]);
        }

        if ($name) {
            $builder->where('DEFAULTASSIGNEDTOUSERID', $name);
        }

        if ($proses) {
            $builder->where('STATUS', $proses);
        }

        $builder->orderBy('IDENTIFIEDDATE', 'desc');

        $data = $builder->paginate(100);

        return view('newpage', ['data' => $data]);
    }

    public function tampiltiket()
    {

        $query = "SELECT
                    p.*,
                    SUBSTR(a.VALUESTRING, 1, 3) AS SHORTDESCRIPTION
                FROM
                    PMBREAKDOWNENTRY p
                LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.FIELDNAME = 'ApprovalDeptUserCode'
                LEFT JOIN DEPARTMENT d ON d.CODE = p.DEPARTMENTCODE
                WHERE
                    BREAKDOWNTYPE = 'SF'
                    AND p.CODE LIKE '%BDIT%'
                    AND DEFAULTASSIGNEDTOUSERID <> ''
                ORDER BY
                    IDENTIFIEDDATE DESC
                  ";
        $results = DB::connection('ibmi')->select($query);


        $formattedTasks = [];
        foreach ($results as $item) {
            // Debug: cek field yang ada
            // dd($item);
            $id = property_exists($item, 'CODE') ? $item->CODE : (property_exists($item, 'code') ? $item->code : null);
            $pic = property_exists($item, 'DEFAULTASSIGNEDTOUSERID') ? $item->DEFAULTASSIGNEDTOUSERID : (property_exists($item, 'defaultassignedtouserid') ? $item->defaultassignedtouserid : '-');
            $date = property_exists($item, 'IDENTIFIEDDATE') ? $item->IDENTIFIEDDATE : (property_exists($item, 'identifieddate') ? $item->identifieddate : null);
            $status = property_exists($item, 'STATUS') ? $item->STATUS : (property_exists($item, 'status') ? $item->status : null);
            $symptom = property_exists($item, 'SYMPTOM') ? $item->SYMPTOM : (property_exists($item, 'symptom') ? $item->symptom : null);
            $shortdesc = property_exists($item, 'SHORTDESCRIPTION') ? $item->SHORTDESCRIPTION : (property_exists($item, 'shortdescription') ? $item->shortdescription : null);

            $formattedTasks[] = [
                'id' => $id,
                'title' => 'Tiket #' . ($id ?? 'N/A'),
                'pic' => $pic,
                'date' => $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : null, // Format ke Y-m-d
                'status' => $status,
                'keterangan' => $symptom ?: '-',
                'departemen' => $shortdesc ?: '-' // Default to '-' if shortdesc is null
            ];
        }
        // dd($formattedTasks); // Debugging line to check the structure of $formattedTasks
        return view('calender', ['tasks' => $formattedTasks]);
    }
    public function getTasksApi()
    {
        $query = "SELECT
                    p.*,
                    SUBSTR(a.VALUESTRING, 1, 3) AS SHORTDESCRIPTION
                FROM
                    PMBREAKDOWNENTRY p
                LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.FIELDNAME = 'ApprovalDeptUserCode'
                LEFT JOIN DEPARTMENT d ON d.CODE = p.DEPARTMENTCODE
                WHERE
                    BREAKDOWNTYPE = 'SF'
                    AND p.CODE LIKE '%BDIT%'
                    AND DEFAULTASSIGNEDTOUSERID <> ''
                ORDER BY
                    IDENTIFIEDDATE DESC";

        $results = DB::connection('ibmi')->select($query);

        $tasks = [];
        foreach ($results as $item) {
            $CODE = $item->code ?? null;
            $DEFAULTASSIGNEDTOUSERID = $item->defaultassignedtouserid ?? '-';
            $IDENTIFIEDDATE = $item->identifieddate ?? null;    // Ambil field sesuai format permintaan
            $STATUS = $item->status ?? null;                    // Ambil field sesuai format permintaan
            $SYMPTOM = isset($item->symptom) ? preg_replace('/[^A-Za-z0-9 .,()-]/', '', $item->symptom) : null;
            $SHORTDESCRIPTION = $item->shortdescription ?? null;
            $statusLabel = match ((string) ($item->status ?? '')) {
                '1' => 'Pending',
                '2' => 'Proses',
                '3' => 'Selesai',
                '4' => 'Dibatalkan',
                default => 'Unknown'
            };

            $tasks[] = [
                'id' => $CODE ?? null,
                'title' => 'Tiket #' . ($CODE ?? 'N/A'),
                'pic' => $DEFAULTASSIGNEDTOUSERID,
                'date' => $IDENTIFIEDDATE ? \Carbon\Carbon::parse($IDENTIFIEDDATE)->format('Y-m-d') : null, // Format ke Y-m-d
                'status' => $statusLabel,
                'keterangan' => $SYMPTOM,
                'departemen' => $SHORTDESCRIPTION
            ];
        }

        return response()->json($tasks);
    }

    public function tiket(Request $request)
    {
        $filters = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'name' => $request->input('name'),
            'proses' => $request->input('proses'),
        ];

        $query = DB::connection('ibmi')->table('PMBREAKDOWNENTRY as p')
            ->leftJoin('DEPARTMENT as d', 'd.CODE', '=', 'p.DEPARTMENTCODE')
            ->select('p.*', 'd.SHORTDESCRIPTION')
            ->where('p.BREAKDOWNTYPE', 'SF')
            ->where('p.CODE', 'like', '%BDIT%')
            ->orderBy('p.IDENTIFIEDDATE', 'desc');

        if ($filters['start_date'] && $filters['end_date']) {
            $query->whereBetween('p.IDENTIFIEDDATE', [$filters['start_date'], $filters['end_date']]);
        }
        if ($filters['name']) {
            $query->where('p.DEFAULTASSIGNEDTOUSERID', $filters['name']);
        }
        if ($filters['proses']) {
            $query->where('p.STATUS', $filters['proses']);
        }

        $tiket = $query->paginate(100);

        return view('tiket', ['tiket' => $tiket]);
    }
}
