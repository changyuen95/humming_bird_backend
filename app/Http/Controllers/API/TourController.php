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

    public function getToursFilter(Request $request){

        $filter_params = $request->filter_params;
        $filteredTours = Tour::all();
        if ($filter_params['types'] && (!in_array('All', $filter_params['types']))) {

            // log::info(implode(",",$filter_params['types']));
            $filteredTours = $filteredTours->filter(function ($tour) use ($filter_params) {
                return !empty(array_intersect($tour['types'], $filter_params['types']));
            });
        }

        if ($filter_params['season'] && (!in_array('All', $filter_params['season']))) {

            $filteredTours = $filteredTours->filter(function ($tour) use ($filter_params) {
                return !empty(array_intersect($tour['types'], $filter_params['season']));
            });
        }

        if ($filter_params['destinations'] && (!in_array('All', $filter_params['destinations'])) ) {

            $filteredTours = $filteredTours->filter(function ($tour) use ($filter_params) {
                return !empty(array_intersect($tour['types'], $filter_params['destinations']));
            });

        }



        if ($filter_params['date'] && (!in_array('All', $filter_params['date'])) ) {

            $filteredTours = $filteredTours->filter(function ($tour) use ($filter_params) {


                foreach ($filter_params['date'] as $month) {
                    $months[] = $month;
                    $months[] = $month+1;
                    $months[] = $month+2;
                }

                // Parse the tour start and end dates
                $tourStartDate = Carbon::parse($tour['from_date']);
                $tourEndDate = Carbon::parse($tour['to_date']);

                // Extract the month for each date
                $tourStartMonth = $tourStartDate->month;
                $tourEndMonth = $tourEndDate->month;

                // Check if either the start month or end month is in the filter months array
                return in_array($tourStartMonth, $months) || in_array($tourEndMonth, $months);
            });





        $final_tours = $filteredTours->values()->all();
        return response()->json([
            'status' => true,
            'tours' => $final_tours,
        ], 200);
    }

}
