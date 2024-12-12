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
use App\Models\TourFare;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'destination' => 'required|string',
                'from_date' => 'required|date',
                'to_date' => 'required|date',
                'price' => 'required|numeric',
                'region' => 'required|string',
                'min_pax' => 'required|numeric',
                'max_pax' => 'required|numeric',
                'season' => 'required|string',
                'days' => 'required|numeric',
                'nights' => 'required|numeric',
                'introduction' => 'required|string',
            ], [
                'required' => 'The :attribute field is required.',
                'numeric' => 'The :attribute must be a valid number.',
                'date' => 'The :attribute must be a valid date.',
                'string' => 'The :attribute must be a valid string.',
            ]);


            // Map the validated data to the Tour model
            $tour = new Tour();
            $tour->name = $validatedData['name'];
            $tour->destination = $validatedData['destination'];
            $tour->from_date = $validatedData['from_date'];
            $tour->to_date = $validatedData['to_date'];
            $tour->price = $validatedData['price'];
            $tour->region = $validatedData['region'];
            $tour->minimum_pax = $validatedData['min_pax'];
            $tour->maximum_pax = $validatedData['max_pax'];

            $tour->season = $validatedData['season'];
            $tour->days = $validatedData['days'];
            $tour->nights = $validatedData['nights'];
            $tour->description = $validatedData['introduction']; // Map 'introduction' to 'description'

            // Save the tour record to the database
            $tour->save();
            try {
                $this->storeOrUpdateRelations($request, $tour->id);
                return redirect()->route('tour.edit', ['id' => $tour->id])->with('success', 'Tour updated successfully.');
            } catch (\Exception $e) {
                // Handle the error gracefully and redirect back with an error message
                return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();;
        }
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
            'region' => 'required|string',
            'min_pax' => 'required|numeric',
            'max_pax' => 'required|numeric',
            'season' => 'required|string',
            'days' => 'required|numeric',
            'nights' => 'required|numeric',
            'introduction' => 'required|string',
        ], [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be a valid number.',
            'date' => 'The :attribute must be a valid date.',
            'string' => 'The :attribute must be a valid string.',
        ]);

        DB::beginTransaction();

            $tour = Tour::findOrFail($id);
            $tour->name = $validatedData['name'];
            $tour->destination = $validatedData['destination'];
            $tour->from_date = $validatedData['from_date'];
            $tour->to_date = $validatedData['to_date'];
            $tour->price = $validatedData['price'];
            $tour->region = $validatedData['region'];
            $tour->minimum_pax = $validatedData['min_pax'];
            $tour->maximum_pax = $validatedData['max_pax'];

            $tour->season = $validatedData['season'];
            $tour->days = $validatedData['days'];
            $tour->nights = $validatedData['nights'];
            $tour->description = $validatedData['introduction']; // Map 'introduction' to 'description'
            $tour->save();
        try {

            $this->storeOrUpdateRelations($request, $tour->id);

            DB::commit();
            return redirect()->route('tour.edit', ['id' => $tour->id])->with('success', 'Tour updated successfully.');
        } catch (\Exception $e) {
            // Handle the error gracefully and redirect back with an error message
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        return redirect()->route('tour.index')->with('success', 'Tour updated successfully.');
    }


    private function storeOrUpdateRelations(Request $request, $tourId)
    {

        try {
            // Validity
            $validityIds = $request->input('validity_ids', []);
            $validities = $request->input('validity', []);
            TourValidity::where('tour_id', $tourId)
                ->whereNotIn('id', $validityIds)
                ->delete();
            foreach ($validities as $index => $validity) {
                TourValidity::updateOrCreate(
                    ['id' => $validityIds[$index] ?? null],
                    ['tour_id' => $tourId, 'validity' => $validity]
                );
            }

            // Exclusions
            $exclusionIds = $request->input('exclusion_ids', []);
            $exclusions = $request->input('exclusion', []);
            TourExclusion::where('tour_id', $tourId)
                ->whereNotIn('id', $exclusionIds)
                ->delete();
            foreach ($exclusions as $index => $exclusion) {
                TourExclusion::updateOrCreate(
                    ['id' => $exclusionIds[$index] ?? null],
                    ['tour_id' => $tourId, 'exclusion' => $exclusion]
                );
            }

            // Inclusions
            $inclusionIds = $request->input('inclusion_ids', []);
            $inclusions = $request->input('inclusion', []);
            TourInclusion::where('tour_id', $tourId)
                ->whereNotIn('id', $inclusionIds)
                ->delete();
            foreach ($inclusions as $index => $inclusion) {
                TourInclusion::updateOrCreate(
                    ['id' => $inclusionIds[$index] ?? null],
                    ['tour_id' => $tourId, 'inclusion' => $inclusion]
                );
            }

            // Payment Terms
            $paymentTermIds = $request->input('payment_term_ids', []);
            $paymentTerms = $request->input('payment_term', []);
            TourPaymentTerm::where('tour_id', $tourId)
                ->whereNotIn('id', $paymentTermIds)
                ->delete();
            foreach ($paymentTerms as $index => $paymentTerm) {
                TourPaymentTerm::updateOrCreate(
                    ['id' => $paymentTermIds[$index] ?? null],
                    ['tour_id' => $tourId, 'payment_term' => $paymentTerm]
                );
            }

            // Tour Fares
            $fareIds = $request->input('fare_ids', []);
            $fareNames = $request->input('fare_name', []);
            $fareAmounts = $request->input('fare_amount', []);
            TourFare::where('tour_id', $tourId)
                ->whereNotIn('id', $fareIds)
                ->delete();
            foreach ($fareNames as $index => $fareName) {
                TourFare::updateOrCreate(
                    ['id' => $fareIds[$index] ?? null],
                    [
                        'tour_id' => $tourId,
                        'name' => $fareName,
                        'price' => $fareAmounts[$index] ?? 0,
                    ]
                );
            }

            // Fetch the currently existing tour types in the database
            $existingTourTypes = TourType::where('tour_id', $tourId)->pluck('type', 'id')->toArray();

            // Handle removed types
            $removedTourTypeIds = $request->input('removed_tour_type_ids', []);
            if (!empty($removedTourTypeIds)) {
                TourType::where('tour_id', $tourId)
                    ->whereIn('id', $removedTourTypeIds)
                    ->delete();
            }

            // Handle added/updated types
            $tourTypes = $request->input('tour_types', []);
            foreach ($tourTypes as $type) {
                // Only create the type if it doesn't already exist
                if (!in_array($type, $existingTourTypes)) {
                    TourType::firstOrCreate(['tour_id' => $tourId, 'type' => $type]);
                }
            }

            // Optionally, handle removing types that are no longer in the submitted list
            TourType::where('tour_id', $tourId)
                ->whereNotIn('type', $tourTypes)
                ->delete();


            // Itineraries
            $itineraryIds = $request->input('itinerary_ids', []);
            $itineraryDays = $request->input('itinerary_day', []);
            $itineraryTitles = $request->input('itinerary_title', []);
            $itineraryMeals = $request->input('itinerary_meal', []);
            $itineraryAccommodations = $request->input('itinerary_accommodation', []);
            $existingImageIds = $request->input('existing_itinerary_images', []);
            $removedImageIds = $request->input('removed_itinerary_image_ids', []);

            // Delete removed itineraries
            TourItinerary::where('tour_id', $tourId)
                ->whereNotIn('id', array_filter($itineraryIds, fn($id) => !str_starts_with($id, 'new')))
                ->delete();

                foreach ($itineraryDays as $index => $day) {
                    $itineraryId = $itineraryIds[$index] ?? null;

                    $itinerary = null;

                    // Handle Existing and New Itineraries
                    if (str_starts_with($itineraryId, 'new')) {
                        $itinerary = TourItinerary::create([
                            'tour_id' => $tourId,
                            'day' => $day,
                            'title' => $itineraryTitles[$index],
                            'meal' => $itineraryMeals[$index],
                            'accommodation' => $itineraryAccommodations[$index],
                        ]);
                    } else {
                        $itinerary = TourItinerary::updateOrCreate(
                            ['id' => $itineraryId],
                            [
                                'tour_id' => $tourId,
                                'day' => $day,
                                'title' => $itineraryTitles[$index],
                                'meal' => $itineraryMeals[$index],
                                'accommodation' => $itineraryAccommodations[$index],
                            ]
                        );
                    }

                    // Handle Highlights
                    $highlightIds = $request->input("itinerary_highlight_ids.{$index}", []);
                    $highlights = $request->input("itinerary_highlights.{$index}", []);
                    TourItineraryHighlight::where('tour_itinerary_id', $itinerary->id)
                        ->whereNotIn('id', array_filter($highlightIds))
                        ->delete();
                    foreach ($highlights as $highlightIndex => $highlight) {
                        TourItineraryHighlight::updateOrCreate(
                            ['id' => $highlightIds[$highlightIndex] ?? null],
                            ['tour_itinerary_id' => $itinerary->id, 'highlight' => $highlight]
                        );
                    }

                    // Handle Uploaded Images
                    if ($request->hasFile("itinerary_images.{$index}")) {
                        foreach ($request->file("itinerary_images.{$index}") as $file) {
                            $path = $file->store('itinerary_images', 'public');
                            TourItineraryImage::create([
                                'tour_itinerary_id' => $itinerary->id,
                                'image' => 'storage/'.$path,
                            ]);
                        }
                    }

                    // Handle Removed Images
                    if (!empty($removedImageIds[$index])) {
                        $imagesToDelete = TourItineraryImage::where('tour_itinerary_id', $itinerary->id)
                            ->whereIn('id', $removedImageIds[$index])
                            ->get();
                        foreach ($imagesToDelete as $image) {
                            Storage::disk('public')->delete($image->image); // Delete file
                            $image->delete(); // Delete database record
                        }
                    }
                }


            // Commit Transaction
        } catch (\Exception $e) {
            // Rollback Transaction on Error
            throw $e;
        }
    }





    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->route('tour.index')->with('success', 'Tour deleted successfully.');
    }
}
