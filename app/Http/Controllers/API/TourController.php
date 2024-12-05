<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class TourController extends Controller
{
    // Get list of tours with filters
    public function getTours(Request $request)
    {
        $filterParams = [
            'date' => $request->get('date'),
            'destinations' => $request->get('destinations'),
            'types' => $request->get('types'),
            'season' => $request->get('season'),
        ];

        // Get all tours from database
        $tours = Tour::query();

        // Apply filters

        // Filter by types
        if (!empty($filterParams['types']) && !in_array('All', $filterParams['types'])) {
            $tours->whereHas('types', function ($query) use ($filterParams) {
                $query->whereIn('name', $filterParams['types']);
            });
        }

        // Filter by season
        if (!empty($filterParams['season']) && !in_array('All', $filterParams['season'])) {
            $tours->whereHas('season', function ($query) use ($filterParams) {
                $query->whereIn('name', $filterParams['season']);
            });
        }

        // Filter by destinations
        if (!empty($filterParams['destinations']) && !in_array('All', $filterParams['destinations'])) {
            $tours->whereIn('destination', $filterParams['destinations']);
        }

        // Filter by date range
        if (!empty($filterParams['date']) && !in_array('All', $filterParams['date'])) {
            $tours = $tours->get()->filter(function ($tour) use ($filterParams) {
                $months = [];
                foreach ($filterParams['date'] as $month) {
                    $months[] = $month;
                    $months[] = $month + 1;
                    $months[] = $month + 2;
                }

                $tourStartDate = Carbon::parse($tour->from_date);
                $tourEndDate = Carbon::parse($tour->to_date);

                $tourStartMonth = $tourStartDate->month;
                $tourEndMonth = $tourEndDate->month;

                return in_array($tourStartMonth, $months) || in_array($tourEndMonth, $months);
            });
        } else {
            $tours = $tours->get();
        }

        return response()->json([
            'status' => true,
            'tours' => $tours->values(),
        ], 200);
    }

    // Get details for a specific tour
    public function getTourDetails($id)
    {
        $tour = Tour::with(['itineraries', 'images', 'paymentTerms', 'inclusions', 'exclusions'])
                    ->find($id);

        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        return response()->json([
            'status' => true,
            'tour' => $tour,
        ], 200);
    }
}
