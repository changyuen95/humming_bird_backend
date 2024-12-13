@extends('voyager::master')

@section('content')
<div class="container-fluid mb-3">
    <a href="{{ route('tour.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Tour Index
    </a>
</div>


    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-sm-12">

                {{-- Display Success and Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

                <div class="card mt-3">
                    <div class="card-header">
                        <span id="card_title">
                            @if(isset($tour))
                                Edit Tour - {{ $tour->name }}
                            @else
                                Create New Tour
                            @endif
                        </span>
                    </div>

                    <div class="card-body">
                        <form action="{{ isset($tour) ? route('tour.update', $tour->id) : route('tour.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($tour))
                                @method('PUT')
                            @endif

                            <!-- Tour Details Section -->
                            <div class="card mb-4">
                                <div class="card-header">Tour Details</div>
                                <div class="card-body">
                                    <div class="form-group col-lg-6">
                                        <label for="name">Tour Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($tour) ? $tour->name : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="introduction">Introduction:</label>
                                        <input type="text" class="form-control" id="introduction" name="introduction" value="{{ old('introduction', isset($tour) ? $tour->description : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="destination">Destination:</label>
                                        <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination', isset($tour) ? $tour->destination : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="region">Region:</label>
                                        <select class="form-control" id="region" name="region" required>
                                            <option value="South America" {{ old('region', isset($tour) ? $tour->region : '') === 'South America' ? 'selected' : '' }}>South America</option>
                                            <option value="Central America" {{ old('region', isset($tour) ? $tour->region : '') === 'Central America' ? 'selected' : '' }}>Central America</option>
                                            <option value="Scandinavia" {{ old('region', isset($tour) ? $tour->region : '') === 'Scandinavia' ? 'selected' : '' }}>Scandinavia</option>
                                            <option value="Central Asia" {{ old('region', isset($tour) ? $tour->region : '') === 'Central Asia' ? 'selected' : '' }}>Central Asia</option>
                                            <option value="East Asia" {{ old('region', isset($tour) ? $tour->region : '') === 'East Asia' ? 'selected' : '' }}>East Asia</option>
                                            <option value="South Asia" {{ old('region', isset($tour) ? $tour->region : '') === 'South Asia' ? 'selected' : '' }}>South Asia</option>
                                            <option value="South-East Asia" {{ old('region', isset($tour) ? $tour->region : '') === 'South-East Asia' ? 'selected' : '' }}>South-East Asia</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="season">Season:</label>
                                        <input type="text" class="form-control" id="season" name="season" value="{{ old('season', isset($tour) ? $tour->season : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="price">Price:</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', isset($tour) ? $tour->price : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="min_pax">Min Pax:</label>
                                        <input type="number" step="1" class="form-control" id="min_pax" name="min_pax" value="{{ old('min_pax', isset($tour) ? $tour->minimum_pax : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="max_pax">Max Pax:</label>
                                        <input type="number" step="1" class="form-control" id="max_pax" name="max_pax" value="{{ old('max_pax', isset($tour) ? $tour->maximum_pax : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="days">Days:</label>
                                        <input type="number" step="1" class="form-control" id="days" name="days" value="{{ old('days', isset($tour) ? $tour->days : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="nights">Nights:</label>
                                        <input type="number" step="1" class="form-control" id="nights" name="nights" value="{{ old('nights', isset($tour) ? $tour->nights : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="from_date">Start Date:</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="{{ old('from_date', isset($tour) ? $tour->from_date : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="to_date">End Date:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" value="{{ old('to_date', isset($tour) ? $tour->to_date : '') }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status', isset($tour) ? $tour->status : '') === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', isset($tour) ? $tour->status : '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>



                                </div>
                            </div>

                            <!-- Tour Main Image Section -->
                                <div class="card mb-4">
                                    <div class="card-header">Tour Main Image</div>
                                    <div class="card-body">
                                        <p><span class="text-muted">Note:</span> This image will be used as the banner for the tour. If left empty, the first itinerary image will be used.</p>
                                        <div class="form-group">
                                            <label for="main-image">Upload Main Image:</label>
                                            <input type="file" id="main-image-input" name="main_image" class="form-control" accept="image/*">
                                            <div class="mt-3">
                                                <label>Uploaded Image:</label>
                                                @if(!empty($tour->image))
                                                    <img style="max-width: 50%" src="{{ asset($tour->image) }}" alt="Main Image" id="mainImagePreview" class="img-fluid">
                                                    {{-- <button type="button" class="btn btn-danger remove-existing-image mt-2">Remove</button> --}}
                                                @else
                                                    <span>No image uploaded. Please upload a main image.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Image Crop Modal -->
                                <div id="mainImageCropModal" class="custom-modal" style="display: none;">
                                    <div class="custom-modal-content">
                                        <span id="closeMainImageModal" class="custom-close">&times;</span>
                                        <h5>Crop Main Image</h5>
                                        <div class="img-container">
                                            <img id="mainImageCropPreview" src="" style="max-width: 100%;">
                                        </div>
                                        <button type="button" id="cropMainImageButton" class="btn btn-primary">Crop</button>
                                        <button type="button" id="closeMainImageModal" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>




                                {{-- @dd($tour->paymentTerms) --}}
                            <!-- Payment terms Section -->
                            <div class="card mb-4">
                                <div class="card-header">Payment Terms</div>
                                <div class="card-body">
                                    <table class="table" id="payment-section">
                                        <thead>
                                            <tr>
                                                <th>Terms</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(old('payment_term') || (isset($tour->paymentTerms) && $tour->paymentTerms->count() > 0))
                                                @foreach(old('payment_term', $tour->paymentTerms ?? []) as $index => $terms)
                                                    <tr>
                                                        <input type="hidden" name="payment_term_ids[]" value="{{ old("payment_term_ids.$index", $terms->id ?? '') }}">
                                                        <td>
                                                            <textarea class="ckeditor-textarea form-control" name="payment_term[]">{{ old("payment_term.$index", $terms->payment_term ?? '') }}</textarea>
                                                        </td>
                                                        <td><button type="button" class="btn btn-danger remove-payment-term-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <input type="hidden" name="payment_term_ids[]" value="">
                                                    <td>
                                                        <textarea class="ckeditor-textarea form-control" name="payment_term[]"></textarea>
                                                    </td>
                                                    <td><button type="button" class="btn btn-danger remove-payment-term-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>

                                    </table>
                                    <button type="button" class="btn btn-success add-payment-term-row">Add Payment Terms</button>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">Tour Validity</div>
                                <div class="card-body">
                                    <table class="table" id="validity-section">
                                        <thead>
                                            <tr>
                                                <th>Validity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $validities = old('validity', isset($tour->validity) ? $tour->validity->toArray() : []);
                                            @endphp
                                            @foreach($validities as $index => $validity)
                                                <tr>
                                                    <input type="hidden" name="validity_ids[]" value="{{ old('validity_ids.'.$index, $validity['id'] ?? '') }}">
                                                    <td><textarea class="ckeditor-textarea form-control" name="validity[]">{{ old('validity.'.$index, $validity['validity'] ?? '') }}</textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-validity-row">Remove</button></td>
                                                </tr>
                                            @endforeach
                                            @if(empty($validities))
                                                <tr>
                                                    <input type="hidden" name="validity_ids[]" value="">
                                                    <td><textarea class="ckeditor-textarea form-control" name="validity[]"></textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-validity-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success add-validity-row">Add Validity</button>
                                </div>
                            </div>


                            <div class="card mb-4">
                                <div class="card-header">Tour Inclusions</div>
                                <div class="card-body">
                                    <table class="table" id="inclusion-section">
                                        <thead>
                                            <tr>
                                                <th>Inclusion</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $inclusions = old('inclusion', isset($tour->inclusions) ? $tour->inclusions->toArray() : []);
                                            @endphp
                                            @foreach($inclusions as $index => $inclusion)
                                                <tr>
                                                    <input type="hidden" name="inclusion_ids[]" value="{{ old('inclusion_ids.'.$index, $inclusion['id'] ?? '') }}">
                                                    <td><textarea class="ckeditor-textarea form-control" name="inclusion[]">{{ old('inclusion.'.$index, $inclusion['inclusion'] ?? '') }}</textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-inclusion-row">Remove</button></td>
                                                </tr>
                                            @endforeach
                                            @if(empty($inclusions))
                                                <tr>
                                                    <input type="hidden" name="inclusion_ids[]" value="">
                                                    <td><textarea class="ckeditor-textarea form-control" name="inclusion[]"></textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-inclusion-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success add-inclusion-row">Add Inclusion</button>
                                </div>
                            </div>


                            <div class="card mb-4">
                                <div class="card-header">Tour Exclusions</div>
                                <div class="card-body">
                                    <table class="table" id="exclusion-section">
                                        <thead>
                                            <tr>
                                                <th>Exclusion</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $exclusions = old('exclusion', isset($tour->exclusions) ? $tour->exclusions->toArray() : []);
                                            @endphp
                                            @foreach($exclusions as $index => $exclusion)
                                                <tr>
                                                    <input type="hidden" name="exclusion_ids[]" value="{{ old('exclusion_ids.'.$index, $exclusion['id'] ?? '') }}">
                                                    <td><textarea class="ckeditor-textarea form-control" name="exclusion[]">{{ old('exclusion.'.$index, $exclusion['exclusion'] ?? '') }}</textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-exclusion-row">Remove</button></td>
                                                </tr>
                                            @endforeach
                                            @if(empty($exclusions))
                                                <tr>
                                                    <input type="hidden" name="exclusion_ids[]" value="">
                                                    <td><textarea class="ckeditor-textarea form-control" name="exclusion[]"></textarea></td>
                                                    <td><button type="button" class="btn btn-danger remove-exclusion-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success add-exclusion-row">Add Exclusion</button>
                                </div>
                            </div>


                            <!-- Tour Itinerary Section -->
                            <div class="card mb-4">
                                <div class="card-header">Tour Itinerary</div>
                                <div class="card-body">
                                    <div id="itinerary-section">
                                        @php
                                            $itineraries = old('itinerary_ids') ? array_map(null, old('itinerary_ids'), old('itinerary_day'), old('itinerary_title'), old('itinerary_meal'), old('itinerary_accommodation'), old('itinerary_highlights')) : (isset($tour->itineraries) ? $tour->itineraries->toArray() : []);
                                        @endphp
                                        @foreach($itineraries as $index => $itinerary)
                                            <div class="card mb-3 itinerary-item">
                                                <div class="card-header">
                                                    Day {{ old("itinerary_day.$index", $itinerary['day'] ?? '') }} - {{ old("itinerary_title.$index", $itinerary['title'] ?? '') }}
                                                    <button type="button" class="btn btn-danger float-right remove-itinerary-row">Remove</button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <input type="hidden" name="itinerary_ids[]" value="{{ old("itinerary_ids.$index", $itinerary['id'] ?? '') }}">
                                                        <div class="col-md-2 mb-3">
                                                            <label>Day</label>
                                                            <input type="number" name="itinerary_day[]" value="{{ old("itinerary_day.$index", $itinerary['day'] ?? '') }}" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label>Title</label>
                                                            <input type="text" name="itinerary_title[]" value="{{ old("itinerary_title.$index", $itinerary['title'] ?? '') }}" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Meal</label>
                                                            <input type="text" name="itinerary_meal[]" value="{{ old("itinerary_meal.$index", $itinerary['meal'] ?? '') }}" class="form-control">
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Accommodation</label>
                                                            <input type="text" name="itinerary_accommodation[]" value="{{ old("itinerary_accommodation.$index", $itinerary['accommodation'] ?? '') }}" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Highlights</label>
                                                            <div class="highlights-container">
                                                                @php
                                                                    $highlights = [];
                                                                    if (old("itinerary_highlights.$index")) {
                                                                        // Use old values directly if they exist
                                                                        $highlights = (array) old("itinerary_highlights.$index");
                                                                    } else {
                                                                        // Use highlights from the database and extract the 'highlight' key
                                                                        $highlights = array_map(fn($highlight) => $highlight['highlight'] ?? '', $itinerary['highlights'] ?? []);
                                                                    }
                                                                    @endphp

                                                                    @foreach($highlights as $highlightIndex => $highlight)
                                                                        <div class="highlight-item mb-2">
                                                                            <input
                                                                                type="text"
                                                                                name="itinerary_highlights[{{ $index }}][]"
                                                                                value="{{ $highlight }}"
                                                                                class="form-control mb-2">
                                                                            <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                                                                        </div>
                                                                    @endforeach

                                                                <button type="button" class="btn btn-success btn-sm add-highlight mt-2" data-itinerary-id="{{ $index }}">Add Highlight</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Images</label>
                                                            <input type="file" name="itinerary_images[{{ $index }}][]" multiple class="form-control image-input">
                                                            <div class="existing-images mt-3">
                                                                <label>Uploaded Images:</label>
                                                                <ul class="list-unstyled">
                                                                    @foreach($itinerary['images'] ?? [] as $image)
                                                                        <li class="existing-image-wrapper mb-2">
                                                                            <img src="{{ asset($image['image']) }}" class="img-thumbnail mb-2" style="width: 100px;">
                                                                            <input type="hidden" name="existing_itinerary_images[{{ $index }}][]" value="{{ $image['id'] }}">
                                                                            <button type="button" class="btn btn-danger btn-sm remove-image" data-image-id="{{ $image['id'] }}">Remove</button>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                                <input type="hidden" name="removed_itinerary_image_ids[{{ $index }}][]" class="removed-image-ids">

                                                            </div>
                                                        </div>

                                                        <!-- Cropper Modal -->
                                                        <div id="customModal" class="custom-modal">
                                                            <div class="custom-modal-content">
                                                                <span class="custom-close">&times;</span>
                                                                <h5>Crop Image</h5>
                                                                <div class="img-container">
                                                                    <img id="cropImagePreview" src="" style="max-width: 100%;">
                                                                </div>
                                                                <button type="button" id="cropImage" class="btn btn-primary">Crop</button>
                                                                <button type="button" class="btn btn-secondary custom-close">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(empty($itineraries))
                                            <div class="card mb-3 itinerary-item">
                                                <div class="card-header">
                                                    New Day - New Title
                                                    <button type="button" class="btn btn-danger float-right remove-itinerary-row">Remove</button>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <input type="hidden" name="itinerary_ids[]" value="">
                                                        <div class="col-md-2 mb-3">
                                                            <label>Day</label>
                                                            <input type="number" name="itinerary_day[]" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label>Title</label>
                                                            <input type="text" name="itinerary_title[]" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Meal</label>
                                                            <input type="text" name="itinerary_meal[]" class="form-control">
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label>Accommodation</label>
                                                            <input type="text" name="itinerary_accommodation[]" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>Highlights</label>
                                                            <div class="highlights-container">
                                                                <div class="highlight-item mb-2">
                                                                    <input type="text" name="itinerary_highlights[new][]" class="form-control mb-2">
                                                                    <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                                                                </div>
                                                                <button type="button" class="btn btn-success btn-sm add-highlight mt-2" data-itinerary-id="new">Add Highlight</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Images</label>
                                                            <input type="file" name="itinerary_images[new][]" multiple class="form-control image-input">
                                                            <div class="existing-images mt-3">
                                                                <label>Uploaded Images:</label>
                                                                <ul class="list-unstyled">
                                                                    <!-- Images will be dynamically added here -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Cropper Modal -->
                                        <div id="customModal" class="custom-modal">
                                            <div class="custom-modal-content">
                                                <span class="custom-close">&times;</span>
                                                <h5>Crop Image</h5>
                                                <div class="img-container">
                                                    <img id="cropImagePreview" src="" style="max-width: 100%;">
                                                </div>
                                                <button type="button" id="cropImage" class="btn btn-primary">Crop</button>
                                                <button type="button" class="btn btn-secondary custom-close">Cancel</button>
                                            </div>
                                        </div>
                                        @endif



                                    </div>
                                    <button type="button" class="btn btn-success add-itinerary-row">Add Itinerary</button>
                                </div>
                            </div>


                            <!-- Tour Types Section -->
                            <div class="card mb-4">
                                <div class="card-header">Tour Types</div>
                                <div class="card-body">
                                    <select class="form-control" id="tour-types" name="tour_types[]" multiple="multiple">
                                        @php
                                            $selectedTourTypes = old('tour_types', isset($tour) ? $tour->types->pluck('type')->toArray() : []);
                                        @endphp
                                        <option value="Adventure" {{ in_array('Adventure', $selectedTourTypes) ? 'selected' : '' }}>Adventure</option>
                                        <option value="Culture" {{ in_array('Culture', $selectedTourTypes) ? 'selected' : '' }}>Culture</option>
                                        <option value="Wellness" {{ in_array('Wellness', $selectedTourTypes) ? 'selected' : '' }}>Wellness</option>
                                        <option value="Art & Lifestyle" {{ in_array('Art & Lifestyle', $selectedTourTypes) ? 'selected' : '' }}>Art & Lifestyle</option>
                                    </select>
                                    <input type="hidden" name="removed_tour_type_ids" id="removed_tour_type_ids">
                                </div>
                            </div>


                            <!-- Tour Payment Terms Section -->
                            <div class="card mb-4">
                                <div class="card-header">Tour Fare Prices</div>
                                <div class="card-body">
                                    <table class="table" id="fare-terms-section">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $fareIds = old('fare_ids', isset($tour->fares) ? $tour->fares->pluck('id')->toArray() : []);
                                                $fareNames = old('fare_name', isset($tour->fares) ? $tour->fares->pluck('name')->toArray() : []);
                                                $fareAmounts = old('fare_amount', isset($tour->fares) ? $tour->fares->pluck('price')->toArray() : []);
                                            @endphp

                                            @if(count($fareIds) > 0)
                                                @foreach($fareIds as $index => $fareId)
                                                    <tr>
                                                        <input type="hidden" name="fare_ids[]" value="{{ $fareId }}">
                                                        <td><input type="text" name="fare_name[]" value="{{ $fareNames[$index] ?? '' }}" class="form-control"></td>
                                                        <td><input type="number" name="fare_amount[]" value="{{ $fareAmounts[$index] ?? '' }}" class="form-control fare-amount"></td>
                                                        <td><button type="button" class="btn btn-danger remove-fare-term-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <input type="hidden" name="fare_ids[]" value="">
                                                    <td><input type="text" name="fare_name[]" class="form-control"></td>
                                                    <td><input type="number" name="fare_amount[]" class="form-control fare-amount"></td>
                                                    <td><button type="button" class="btn btn-danger remove-fare-term-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success add-fare-term-row">Add New Fares</button>
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Save Tour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery before Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <script>
        $(document).ready(function () {

            let mainImageCropper;
            let mainImageFile;

            $(document).on('click', '.remove-existing-image', function () {
                $('#existingMainImageSection').hide();
                $('#newMainImageSection').show();
                $('#removeExistingMainImage').val(1); // Mark the existing image for removal
            });


            // Handle Main Image Upload
            $('#main-image-input').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#newImagePreview').attr('src', e.target.result);
                        $('#newImagePreviewWrapper').show();

                        // Initialize Cropper.js
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(document.getElementById('newImagePreview'), {
                            aspectRatio: 16 / 9,
                            viewMode: 1,
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Open Crop Modal for Main Image
            $('#crop-main-image').on('click', function () {
                const imageSrc = $('#mainImagePreview').attr('src');
                $('#mainImageCropPreview').attr('src', imageSrc);

                // Initialize Cropper.js
                if (mainImageCropper) {
                    mainImageCropper.destroy();
                }
                mainImageCropper = new Cropper(document.getElementById('mainImageCropPreview'), {
                    aspectRatio: 16 / 9, // Adjust as needed
                    viewMode: 1,
                });

                $('#mainImageCropModal').fadeIn();
            });

            $('#cropMainImage').on('click', function () {
                const imageElement = document.getElementById('mainImagePreview');
                if (imageElement) {
                    // Initialize cropper for the main image
                    cropper = new Cropper(imageElement, {
                        aspectRatio: 16 / 9, // Adjust as needed
                        viewMode: 1,
                    });

                    $('#customModal').fadeIn(); // Show modal for cropping
                }
            });


            // Handle Crop for Main Image
            $('#cropMainImageButton').on('click', function () {
                if (mainImageCropper) {
                    const croppedCanvas = mainImageCropper.getCroppedCanvas();
                    croppedCanvas.toBlob(function (blob) {
                        const croppedFile = new File([blob], "cropped-main-image.jpg", { type: "image/jpeg" });
                        mainImageFile = croppedFile;

                        const croppedImageSrc = URL.createObjectURL(blob);
                        $('#main-image-preview').html(`
                            <img src="${croppedImageSrc}" class="img-thumbnail mb-3" style="max-width: 200px;">
                        `);

                        $('#mainImageCropModal').fadeOut();
                        mainImageCropper.destroy();
                        mainImageCropper = null;
                    });
                }
            });

            // Close Crop Modal (Specific to Main Image)
            $('#closeMainImageModal').on('click', function () {
                $('#mainImageCropModal').fadeOut();
                if (mainImageCropper) {
                    mainImageCropper.destroy();
                    mainImageCropper = null;
                }
            });

            //itinerary images

            let cropper;
            let currentInput = null; // Track the current input
            let currentListItem = null; // Track the list item being cropped

            // Handle file input change
            $(document).on('change', '.image-input', function (event) {
                currentInput = event.target; // Assign the current input when a file is selected

                const files = Array.from(event.target.files); // Convert files to an array
                const inputElement = event.target; // Reference the file input

                files.forEach((file, index) => {
                    // Add each image to the preview list
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const previewList = $(inputElement).closest('.col-md-6').find('.existing-images ul');
                        const listItem = $('<li>').addClass('existing-image-wrapper mb-2');
                        const previewImage = $('<img>')
                            .attr('src', e.target.result)
                            .addClass('img-thumbnail mb-2')
                            .css('width', '100px');
                        const removeButton = $('<button>')
                            .attr('type', 'button') // Prevent form submission
                            .addClass('btn btn-danger btn-sm remove-image')
                            .text('Remove')
                            .data('file-index', index); // Store index for reference

                        const cropButton = $('<button>')
                            .attr('type', 'button') // Prevent form submission
                            .addClass('btn btn-warning btn-sm crop-again')
                            .text('Crop');

                        listItem.append(previewImage).append(removeButton).append(cropButton);
                        previewList.append(listItem);
                    };
                    reader.readAsDataURL(file);
                });
            });




            // Open cropper modal for cropping (when clicking "Crop" beside "Remove")
            $(document).on('click', '.crop-again', function () {
                const imageSrc = $(this).siblings('img').attr('src');
                if (!imageSrc) {
                    console.error('Image source is missing or undefined.');
                    return;
                }

                currentListItem = $(this).closest('li'); // Track the current list item
                $('#cropImagePreview').attr('src', imageSrc);

                const cropImagePreview = document.getElementById('cropImagePreview');
                if (!cropImagePreview) {
                    console.error('#cropImagePreview element is missing.');
                    console.log('DOM structure:', document.body.innerHTML); // Log DOM for debugging
                    return;
                }

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImagePreview, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                });

                $('#customModal').fadeIn();
            });



            $('#cropImagePreview').on('load', function () {
                // Ensure the image is loaded before initializing the cropper
                const cropImageElement = document.getElementById('cropImagePreview');
                if (cropImageElement && cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropImageElement, {
                    aspectRatio: 16 / 9, // Adjust as needed
                    viewMode: 1,
                });

                $('#customModal').fadeIn(); // Show the modal
            });


            // Handle cropping in the modal
            $('#cropImage').on('click', function () {
                if (cropper) {
                    const croppedCanvas = cropper.getCroppedCanvas();
                    croppedCanvas.toBlob(function (blob) {
                        // Option 1: Replace original file
                        const file = new File([blob], "cropped.jpg", { type: "image/jpeg" });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        currentInput.files = dataTransfer.files;

                        // Option 2: Add a hidden input for the cropped image
                        const croppedImageSrc = croppedCanvas.toDataURL('image/jpeg');
                        const hiddenInput = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', `cropped_images[${currentInput.dataset.itineraryId}][]`)
                            .val(croppedImageSrc);
                        $(currentInput).closest('.col-md-6').append(hiddenInput);

                        $('#customModal').fadeOut();
                        cropper.destroy();
                        cropper = null;
                    });
                }
            });


            // Close the cropper modal
            $(document).on('click', '.custom-close', function () {
                $('#customModal').fadeOut();
                if (cropper) {
                    cropper.destroy();
                    cropper = null; // Reset cropper
                }
            });

            $(document).on('click', '.remove-image', function () {
                const fileIndex = $(this).data('file-index');
                const imageId = $(this).data('image-id'); // For existing images from the server
                const fileInput = $(this).closest('.col-md-6').find('.image-input')[0];
                const removedImageInput = $(this).closest('.col-md-6').find('.removed-image-ids'); // Hidden input to store removed image IDs

                // Remove the image preview
                $(this).closest('.existing-image-wrapper').remove();

                // Handle newly uploaded files (client-side)
                if (fileInput.files && typeof fileIndex !== 'undefined') {
                    const dataTransfer = new DataTransfer();
                    Array.from(fileInput.files).forEach((file, index) => {
                        if (index !== fileIndex) {
                            dataTransfer.items.add(file);
                        }
                    });
                    fileInput.files = dataTransfer.files; // Update the file input
                }

                // Handle existing images (server-side)
                if (imageId) {
                    const currentValue = removedImageInput.val();
                    removedImageInput.val(currentValue ? `${currentValue},${imageId}` : imageId); // Append the image ID
                }
            });


            // Remove an image
            // $(document).on('click', '.remove-image', function () {
            //     $(this).closest('.existing-image-wrapper').remove();
            // });



                // Initialize Select2 for tour types
                $('#tour-types').select2({
                    tags: false,
                    tokenSeparators: [',', ' '],
                    placeholder: "Select tour types",
                });

                // Calculate and update the Total Amount

                let itineraryIndex = $('#itinerary-section .itinerary-item').length; // Initialize based on existing rows

                // Add new Itinerary row
                $('.add-itinerary-row').click(function () {
                    const newItineraryCard = `
                        <div class="card mb-3 itinerary-item" data-itinerary-index="${itineraryIndex}">
                            <div class="card-header">
                                Day <input type="number" name="itinerary_day[${itineraryIndex}]" value="" class="form-control d-inline-block w-auto">
                                <button type="button" class="btn btn-danger float-right remove-itinerary-row">Remove</button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Title</label>
                                        <input type="text" name="itinerary_title[${itineraryIndex}]" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Meal</label>
                                        <input type="text" name="itinerary_meal[${itineraryIndex}]" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label>Accommodation</label>
                                        <input type="text" name="itinerary_accommodation[${itineraryIndex}]" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Highlights</label>
                                        <div class="highlights-container">
                                            <div class="highlight-item mb-2">
                                                <input type="text" name="itinerary_highlights[${itineraryIndex}][]" class="form-control mb-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm add-highlight mt-2" data-itinerary-id="${itineraryIndex}">Add Highlight</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Images</label>
                                        <input type="file" name="itinerary_images[${itineraryIndex}][]" multiple class="form-control image-input">
                                        <div class="existing-images mt-3">
                                            <label>Uploaded Images:</label>
                                            <ul class="list-unstyled">
                                                <!-- Images will be dynamically added here -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#itinerary-section').append(newItineraryCard);

                    // Rebind crop functionality to the newly added row
                    rebindCropFunctionality();
                    itineraryIndex++;
                });

                function rebindCropFunctionality() {
                $(document).off('click', '.crop-again').on('click', '.crop-again', function () {
                    const imageSrc = $(this).siblings('img').attr('src');
                    currentListItem = $(this).closest('li');
                    $('#cropImagePreview').attr('src', imageSrc);

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(document.getElementById('cropImagePreview'), {
                        aspectRatio: 16 / 9,
                        viewMode: 1,
                    });

                    $('#customModal').fadeIn();
                });

                $('#cropImage').off('click').on('click', function () {
                    if (cropper) {
                        const croppedCanvas = cropper.getCroppedCanvas();
                        croppedCanvas.toBlob(function (blob) {
                            const file = new File([blob], "cropped.jpg", { type: "image/jpeg" });

                            // Update the file input with the cropped image
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);

                            if (currentInput) {
                                currentInput.files = dataTransfer.files;

                                // Update the image preview
                                const croppedImageSrc = URL.createObjectURL(blob);
                                $(currentInput)
                                    .closest('.col-md-6') // Find the related section
                                    .find('.existing-images ul') // Update the image preview
                                    .html(`
                                        <li class="existing-image-wrapper mb-2">
                                            <img src="${croppedImageSrc}" class="img-thumbnail mb-2" style="width: 100px;">
                                            <button type="button" class="btn btn-danger btn-sm remove-image">Remove</button>
                                            <button type="button" class="btn btn-warning btn-sm crop-again">Crop</button>
                                        </li>
                                    `);
                            }

                            // Close the modal and destroy the cropper
                            $('#customModal').fadeOut();
                            cropper.destroy();
                            cropper = null;
                        }, 'image/jpeg');
                    }
                });

            }

            // Ensure crop modal is always available
            if (!document.getElementById('customModal')) {
                const modalHtml = `
                    <div id="customModal" class="custom-modal">
                        <div class="custom-modal-content">
                            <span class="custom-close">&times;</span>
                            <h5>Crop Image</h5>
                            <div class="img-container">
                                <img id="cropImagePreview" src="" style="max-width: 100%;">
                            </div>
                            <button type="button" id="cropImage" class="btn btn-primary">Crop</button>
                            <button type="button" class="btn btn-secondary custom-close">Cancel</button>
                        </div>
                    </div>`;
                $('body').append(modalHtml);
            }


               // Remove Itinerary row and re-index
                $(document).on('click', '.remove-itinerary-row', function () {
                    $(this).closest('.itinerary-item').remove();

                    // Re-index all rows
                    $('#itinerary-section .itinerary-item').each(function (index) {
                        $(this).attr('data-itinerary-index', index);
                        $(this).find('[name^="itinerary_day"]').attr('name', `itinerary_day[${index}]`);
                        $(this).find('[name^="itinerary_title"]').attr('name', `itinerary_title[${index}]`);
                        $(this).find('[name^="itinerary_meal"]').attr('name', `itinerary_meal[${index}]`);
                        $(this).find('[name^="itinerary_accommodation"]').attr('name', `itinerary_accommodation[${index}]`);
                        $(this).find('[name^="itinerary_highlights"]').attr('name', `itinerary_highlights[${index}][]`);
                        $(this).find('[name^="itinerary_images"]').attr('name', `itinerary_images[${index}][]`);
                    });

                    itineraryIndex = $('#itinerary-section .itinerary-item').length; // Reset the index counter
                });




                $('.add-validity-row').click(function () {
                    const newRow = `
                        <tr>
                            <input type="hidden" name="validity_ids[]" value="">
                            <td>
                                <textarea class="ckeditor-textarea form-control" name="validity[]"></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-validity-row">Remove</button>
                            </td>
                        </tr>`;
                    $('#validity-section tbody').append(newRow);

                    // Initialize CKEditor for the new row
                    CKEDITOR.replace($('#validity-section tbody').find('textarea').last()[0], {
                        toolbar: [
                            { name: 'basicstyles', items: ['Bold', 'Underline'] }
                        ],
                        removeButtons: 'Italic,Strike,Subscript,Superscript',
                        allowedContent: 'b u br', // Allow <b>, <u>, and <br>
                        enterMode: CKEDITOR.ENTER_BR, // Use <br> when pressing Enter
                        shiftEnterMode: CKEDITOR.ENTER_BR // Use <br> when pressing Shift+Enter
                    });
                });


                $('.add-payment-term-row').click(function () {
                    const newRow = `
                        <tr>
                            <input type="hidden" name="payment_term_ids[]" value="">
                            <td>
                                <textarea class="ckeditor-textarea form-control" name="payment_term[]"></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-payment-term-row">Remove</button>
                            </td>
                        </tr>`;
                    $('#payment-section tbody').append(newRow);

                    // Initialize CKEditor for the new row
                    CKEDITOR.replace($('#payment-section tbody').find('textarea').last()[0], {
                        toolbar: [
                            { name: 'basicstyles', items: ['Bold', 'Underline'] }
                        ],
                        removeButtons: 'Italic,Strike,Subscript,Superscript',
                        allowedContent: 'b u br', // Allow <b>, <u>, and <br>
                        enterMode: CKEDITOR.ENTER_BR, // Use <br> when pressing Enter
                        shiftEnterMode: CKEDITOR.ENTER_BR // Use <br> when pressing Shift+Enter
                    });

                });

                $('.add-inclusion-row').click(function () {
                    const newRow = `
                        <tr>
                            <input type="hidden" name="inclusion_ids[]" value="">
                            <td>
                                <textarea class="ckeditor-textarea form-control" name="inclusion[]"></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-inclusion-row">Remove</button>
                            </td>
                        </tr>`;
                    $('#inclusion-section tbody').append(newRow);

                    // Initialize CKEditor for the new row
                    CKEDITOR.replace($('#inclusion-section tbody').find('textarea').last()[0], {
                        toolbar: [
                            { name: 'basicstyles', items: ['Bold', 'Underline'] }
                        ],
                        removeButtons: 'Italic,Strike,Subscript,Superscript'
                    });
                });

                $('.add-exclusion-row').click(function () {
                    const newRow = `
                        <tr>
                            <input type="hidden" name="exclusion_ids[]" value="">
                            <td>
                                <textarea class="ckeditor-textarea form-control" name="exclusion[]"></textarea>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-exclusion-row">Remove</button>
                            </td>
                        </tr>`;
                    $('#exclusion-section tbody').append(newRow);

                    // Initialize CKEditor for the new row
                    CKEDITOR.replace($('#exclusion-section tbody').find('textarea').last()[0], {
                        toolbar: [
                            { name: 'basicstyles', items: ['Bold', 'Underline'] }
                        ],
                        removeButtons: 'Italic,Strike,Subscript,Superscript',
                        allowedContent: 'b u br', // Allow <b>, <u>, and <br>
                        enterMode: CKEDITOR.ENTER_BR, // Use <br> when pressing Enter
                        shiftEnterMode: CKEDITOR.ENTER_BR // Use <br> when pressing Shift+Enter
                    });
                });

                    // Generic handler for removing rows
                    $(document).on('click', '.remove-validity-row, .remove-payment-term-row, .remove-inclusion-row, .remove-exclusion-row', function () {
                        $(this).closest('tr').remove();
                    });



                // Remove Itinerary row
                $(document).on('click', '.remove-itinerary-row', function () {
                    $(this).closest('.itinerary-item').remove();
                });

                $(document).on('click', '.add-highlight', function () {
                    const itineraryId = $(this).data('itinerary-id');
                    const highlightContainer = $(this).closest('.highlights-container'); // Target the correct container
                    const newHighlight = `
                        <div class="highlight-item mb-2">
                            <input type="text" name="itinerary_highlights[${itineraryId}][]" class="form-control mb-2">
                            <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                        </div>`;

                    highlightContainer.append(newHighlight); // Use append to add the new row at the bottom
                });


                // Remove Highlight row
                $(document).on('click', '.remove-highlight', function () {
                    $(this).closest('.highlight-item').remove();
                });

                // Remove Image functionality
                $(document).on('click', '.remove-image', function () {
                    const imageId = $(this).data('image-id');
                    // Add the ID to the removed image input field or handle with AJAX
                    $(this).closest('.existing-image-wrapper').remove();
                });

                // Trigger total amount calculation on payment amount change


                // Add new Payment Term row
                $('.add-fare-term-row').click(function () {
                    const tableBody = $('#fare-terms-section tbody');
                    const newRow = `
                        <tr>
                            <input type="hidden" name="fare_term_ids[]" value="">
                            <td><input type="text" name="fare_name[]" class="form-control"></td>
                            <td><input type="number" name="fare_amount[]" class="form-control fare-amount"></td>
                            <td><button type="button" class="btn btn-danger remove-fare-term-row">Remove</button></td>
                        </tr>`;
                    tableBody.append(newRow);
                });

                // Remove Payment Term row and update total amount
                $(document).on('click', '.remove-fare-term-row', function () {
                    $(this).closest('tr').remove();

                });

                // Initial calculation of total amount if there are existing payment terms
            });

            document.addEventListener('DOMContentLoaded', function () {
                // Initialize CKEditor for all existing textareas
                document.querySelectorAll('.ckeditor-textarea').forEach((textarea) => {
                    CKEDITOR.replace(textarea, {
                        toolbar: [
                            { name: 'basicstyles', items: ['Bold', 'Underline'] }
                        ],
                        removeButtons: 'Italic,Strike,Subscript,Superscript',
                        allowedContent: 'b u br', // Allow <b>, <u>, and <br>
                        enterMode: CKEDITOR.ENTER_BR, // Use <br> when pressing Enter
                        shiftEnterMode: CKEDITOR.ENTER_BR // Use <br> when pressing Shift+Enter
                    });
                });
            });
    </script>
@endsection

