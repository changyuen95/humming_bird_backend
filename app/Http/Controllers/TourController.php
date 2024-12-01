<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourItinerary;
use App\Models\TourItineraryHighlight;
use App\Models\TourItineraryImage;
use App\Models\TourValidity;
use App\Models\TourPaymentTerm;
use App\Models\TourInclusion;
use App\Models\TourExclusion;
use App\Models\TourType;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::orderBy('updated_at', 'desc')->paginate(10);
        return view('tour', compact('tours'));
    }

    public function create()
    {
        return view('tour_detail');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'price' => 'required|numeric',
        ]);

        $tour = Tour::create($validatedData);
        $this->storeOrUpdateRelations($request, $tour->id);

        return redirect()->route('tour.index')->with('success', 'Tour created successfully.');
    }

    public function edit($id)
    {
        $tour = Tour::with([
            'itineraries.highlights', 'itineraries.images', 'validity', 'paymentTerms', 'inclusions', 'exclusions', 'types'
        ])->findOrFail($id);

        return view('tour_detail', compact('tour'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'price' => 'required|numeric',
        ]);

        $tour = Tour::findOrFail($id);
        $tour->update($validatedData);
        $this->storeOrUpdateRelations($request, $tour->id);

        return redirect()->route('tour.index')->with('success', 'Tour updated successfully.');
    }

    private function storeOrUpdateRelations(Request $request, $tourId)
    {
        // Validity
        $validityIds = $request->input('validity_ids', []);
        $validities = $request->input('validity', []);

        foreach ($validities as $index => $validity) {
            TourValidity::updateOrCreate(
                ['id' => $validityIds[$index] ?? null],
                ['tour_id' => $tourId, 'validity' => $validity]
            );
        }

        // Payment Terms
        $paymentTermIds = $request->input('payment_term_ids', []);
        $paymentNames = $request->input('payment_name', []);
        $paymentAmounts = $request->input('payment_amount', []);

        foreach ($paymentNames as $index => $name) {
            TourPaymentTerm::updateOrCreate(
                ['id' => $paymentTermIds[$index] ?? null],
                ['tour_id' => $tourId, 'name' => $name, 'amount' => $paymentAmounts[$index]]
            );
        }

        // Inclusions
        $inclusionIds = $request->input('inclusion_ids', []);
        $inclusions = $request->input('inclusion', []);

        foreach ($inclusions as $index => $inclusion) {
            TourInclusion::updateOrCreate(
                ['id' => $inclusionIds[$index] ?? null],
                ['tour_id' => $tourId, 'inclusion' => $inclusion]
            );
        }

        // Exclusions
        $exclusionIds = $request->input('exclusion_ids', []);
        $exclusions = $request->input('exclusion', []);

        foreach ($exclusions as $index => $exclusion) {
            TourExclusion::updateOrCreate(
                ['id' => $exclusionIds[$index] ?? null],
                ['tour_id' => $tourId, 'exclusion' => $exclusion]
            );
        }

        // Tour Types
        $tourTypeIds = $request->input('tour_type_ids', []);
        $tourTypes = $request->input('tour_types', []);

        foreach ($tourTypes as $index => $type) {
            TourType::updateOrCreate(
                ['id' => $tourTypeIds[$index] ?? null],
                ['tour_id' => $tourId, 'type' => $type]
            );
        }


        // Itineraries
        $itineraryIds = $request->input('itinerary_ids', []);
        $itineraryDays = $request->input('itinerary_day', []);
        $itineraryTitles = $request->input('itinerary_title', []);
        $itineraryMeals = $request->input('itinerary_meal', []);
        $itineraryAccommodations = $request->input('itinerary_accommodation', []);

        foreach ($itineraryDays as $index => $day) {
            $itinerary = TourItinerary::updateOrCreate(
                ['id' => $itineraryIds[$index] ?? null],
                ['tour_id' => $tourId, 'day' => $day, 'title' => $itineraryTitles[$index], 'meal' => $itineraryMeals[$index], 'accommodation' => $itineraryAccommodations[$index]]
            );

            // Itinerary Highlights
            $highlightIds = $request->input('itinerary_highlights')[$index] ?? [];
            $highlights = $request->input('itinerary_highlights')['new'][$index] ?? [];
            dd($request);
            foreach ($highlights as $highlightIndex => $highlight) {
                dd($request);
                TourItineraryHighlight::updateOrCreate(
                    ['id' => $highlightIds[$highlightIndex] ?? null],
                    ['tour_itinerary_id' => $itinerary->id, 'highlight' => $highlight]
                );
            }

            // Itinerary Images
            if ($request->hasFile("itinerary_images.$index")) {
                foreach ($request->file("itinerary_images.$index") as $file) {
                    $path = $file->store('itinerary_images', 'public');
                    TourItineraryImage::create(['tour_itinerary_id' => $itinerary->id, 'image' => $path]);
                }
            }
        }

        dd($request);

    }

    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->route('tour.index')->with('success', 'Tour deleted successfully.');
    }
}
