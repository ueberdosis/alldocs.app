<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use App\Services\FileFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $conversions = FileFormat::conversions();

        $mostUsedConversions = Cache::remember('mostUsedConversions', now()->addMinutes(15), function () use ($conversions) {
            return Conversion::groupBy(DB::raw("CONCAT(`from`, '-', `to`)"))
                ->orderBy(DB::raw('COUNT(*)'), 'desc')
                ->get(['from', 'to'])
                ->map(function ($item) use ($conversions) {
                    return $conversions
                        ->where('inputFormat.name', $item->from)
                        ->where('outputFormat.name', $item->to)
                        ->first();
                });
        });

        return view('pages.home.index', [
            'conversions' => $conversions,
            'mostUsedConversions' => $mostUsedConversions,
        ]);
    }
}
