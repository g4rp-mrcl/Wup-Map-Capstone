<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $announcements = [
            [
                'name' => 'Still the ONLY ONE in Nueva Ecija WUP Retains Autonomous Status',
                'description' => 'Congratulations! Wesleyan University-Philippines retains autonomous status
                still the only one in Nueva Ecija...'
            ],
            [
                'name' => 'WUP Triumphs ISO 9001:2015',
                'description' => 'WU-P Triumphs ISO 9001:2015 Second Surveillance Audit, Maintains Certification...'
            ],
            [
                'name' => 'WU-P Now ASEAN University Network-Quality Assurance Associate Member',
                'description' => 'Wesleyan University-Philippines now an associate member of the ASEAN University Network-Quality Assurance (AUN-QA)...'
            ],
        ];
        return view('dashboard')->with('announcements', json_encode($announcements));
    }
}
