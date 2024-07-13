<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class infoBidangLainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function teknikArsitek()
    {
        return view('pages.info-bidang-lain.teknik-arsitek');
    }

    public function teknikSipil()
    {
        return view('pages.info-bidang-lain.teknik-sipil');
    }

    public function ilmuKomputer()
    {
        return view('pages.info-bidang-lain.ilmu-komputer');
    }

    public function ilmuEkonomiManajemen()
    {
        return view('pages.info-bidang-lain.ilmu-ekonomi-manajemen');
    }

    public function ilmuEkonomiAkuntansi()
    {
        return view('pages.info-bidang-lain.ilmu-ekonomi-akuntansi');
    }

    public function agroteknologi()
    {
        return view('pages.info-bidang-lain.agroteknologi');
    }

    public function ilmuKomunikasi()
    {
        return view('pages.info-bidang-lain.ilmu-komunikasi');
    }

    public function teknikElektro()
    {
        return view('pages.info-bidang-lain.teknik-elektro');
    }

    public function teknikIndustri()
    {
        return view('pages.info-bidang-lain.teknik-industri');
    }
}
