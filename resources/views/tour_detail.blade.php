@extends('voyager::master')

@section('content')
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-sm-12">

                {{-- Display Success and Error Messages --}}
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                                    <div class="form-group">
                                        <label for="name">Tour Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ isset($tour) ? $tour->name : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="destination">Destination:</label>
                                        <input type="text" class="form-control" id="destination" name="destination" value="{{ isset($tour) ? $tour->destination : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price:</label>
                                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ isset($tour) ? $tour->price : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="{{ isset($tour) ? $tour->from_date : '' }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" value="{{ isset($tour) ? $tour->to_date : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Tour Validity Section -->
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
                                            @if(isset($tour->validity) && $tour->validity->count() > 0)
                                                @foreach($tour->validity as $validity)
                                                    <tr>
                                                        <input type="hidden" name="validity_ids[]" value="{{ $validity->id }}">
                                                        <td><textarea class="ckeditor-textarea form-control" name="validity[]">{{ $validity->validity }}</textarea></td>
                                                        <td><button type="button" class="btn btn-danger remove-validity-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
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

                            <!-- Tour Inclusion Section -->
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
                                            @if(isset($tour->inclusions) && $tour->inclusions->count() > 0)
                                                @foreach($tour->inclusions as $inclusion)
                                                    <tr>
                                                        <input type="hidden" name="inclusion_ids[]" value="{{ $inclusion->id }}">
                                                        <td><textarea class="ckeditor-textarea form-control" name="inclusion[]">{{ $inclusion->inclusion }}</textarea></td>
                                                        <td><button type="button" class="btn btn-danger remove-inclusion-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
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

                            <!-- Tour Exclusion Section -->
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
                                            @if(isset($tour->exclusions) && $tour->exclusions->count() > 0)
                                                @foreach($tour->exclusions as $exclusion)
                                                    <tr>
                                                        <input type="hidden" name="exclusion_ids[]" value="{{ $exclusion->id }}">
                                                        <td><textarea class="ckeditor-textarea form-control" name="exclusion[]">{{ $exclusion->exclusion }}</textarea></td>
                                                        <td><button type="button" class="btn btn-danger remove-exclusion-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
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
                                        @if(isset($tour->itineraries) && $tour->itineraries->count() > 0)
                                            @foreach($tour->itineraries as $itinerary)
                                                <div class="card mb-3 itinerary-item">
                                                    <div class="card-header">
                                                        Day {{ $itinerary->day }} - {{ $itinerary->title }}
                                                        <button type="button" class="btn btn-danger float-right remove-itinerary-row">Remove</button>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <input type="hidden" name="itinerary_ids[]" value="{{ $itinerary->id }}">
                                                            <div class="col-md-2 mb-3">
                                                                <label>Day</label>
                                                                <input type="number" name="itinerary_day[]" value="{{ $itinerary->day }}" class="form-control" required>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label>Title</label>
                                                                <input type="text" name="itinerary_title[]" value="{{ $itinerary->title }}" class="form-control" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label>Meal</label>
                                                                <input type="text" name="itinerary_meal[]" value="{{ $itinerary->meal }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label>Accommodation</label>
                                                                <input type="text" name="itinerary_accommodation[]" value="{{ $itinerary->accommodation }}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Highlights</label>
                                                                <div class="highlights-container">
                                                                    @if(isset($itinerary->highlights) && $itinerary->highlights->count() > 0)
                                                                        @foreach($itinerary->highlights as $highlight)
                                                                            <div class="highlight-item mb-2">
                                                                                <input type="text" name="itinerary_highlights[{{ $itinerary->id }}][]" value="{{ $highlight->highlight }}" class="form-control mb-2">
                                                                                <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                    <button type="button" class="btn btn-success btn-sm add-highlight mt-2" data-itinerary-id="{{ $itinerary->id }}">Add Highlight</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Images</label>
                                                                <input type="file" name="itinerary_images[{{ $itinerary->id }}][]" multiple class="form-control">
                                                                <div class="existing-images mt-3">
                                                                    <label>Uploaded Images:</label>
                                                                    <ul class="list-unstyled">
                                                                        @foreach($itinerary->images as $image)
                                                                            <li class="existing-image-wrapper mb-2">
                                                                                <img src="{{ asset($image->image) }}" alt="Itinerary Image" class="img-thumbnail mb-2" width="100">
                                                                                <button type="button" class="btn btn-danger btn-sm remove-image" data-image-id="{{ $image->id }}">Remove Image</button>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                        @foreach($tour->types as $tourType)
                                            <option value="{{ $tourType->id }}"
                                                @if(isset($tour) && $tour->types->contains($tourType->id)) selected @endif>
                                                {{ $tourType->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="removed_tour_type_ids" id="removed_tour_type_ids">
                                </div>
                            </div>

                            <!-- Tour Payment Terms Section -->
                            <div class="card mb-4">
                                <div class="card-header">Tour Payment Terms</div>
                                <div class="card-body">
                                    <table class="table" id="payment-terms-section">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($tour->paymentTerms) && $tour->paymentTerms->count() > 0)
                                                @foreach($tour->paymentTerms as $paymentTerm)
                                                    <tr>
                                                        <input type="hidden" name="payment_term_ids[]" value="{{ $paymentTerm->id }}">
                                                        <td><input type="text" name="payment_name[]" value="{{ $paymentTerm->name }}" class="form-control"></td>
                                                        <td><input type="number" name="payment_amount[]" value="{{ $paymentTerm->amount }}" class="form-control payment-amount"></td>
                                                        <td><button type="button" class="btn btn-danger remove-payment-term-row">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <input type="hidden" name="payment_term_ids[]" value="">
                                                    <td><input type="text" name="payment_name[]" class="form-control"></td>
                                                    <td><input type="number" name="payment_amount[]" class="form-control payment-amount"></td>
                                                    <td><button type="button" class="btn btn-danger remove-payment-term-row">Remove</button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <!-- Fixed Total Row -->
                                        <tfoot>
                                            <tr>
                                                <td><input type="text" class="form-control" value="Total" readonly></td>
                                                <td><input type="number" id="total_amount" name="total_amount" class="form-control" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <button type="button" class="btn btn-success add-payment-term-row">Add Payment Term</button>
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

    <script>
        $(document).ready(function () {
            // Initialize Select2 for tour types
            $('#tour-types').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Add or select tour types",
            });

            // Calculate and update the Total Amount
            function updateTotalAmount() {
                let total = 0;
                $('.payment-amount').each(function () {
                    const amount = parseFloat($(this).val());
                    if (!isNaN(amount)) {
                        total += amount;
                    }
                });
                $('#total_amount').val(total);
            }

            // Add new Itinerary row
            $('.add-itinerary-row').click(function () {
                const newItineraryCard = `
                    <div class="card mb-3 itinerary-item">
                        <div class="card-header">
                            New Day - New Title
                            <button type="button" class="btn btn-danger float-right remove-itinerary-row">Remove</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
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
                                    <input type="file" name="itinerary_images[new][]" multiple class="form-control">
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
            });

            // Remove Itinerary row
            $(document).on('click', '.remove-itinerary-row', function () {
                $(this).closest('.itinerary-item').remove();
            });

            // Add new Highlight row
            $(document).on('click', '.add-highlight', function () {
                const itineraryId = $(this).data('itinerary-id');
                const highlightContainer = $(this).closest('.highlights-container');
                const newHighlight = `
                    <div class="highlight-item mb-2">
                        <input type="text" name="itinerary_highlights[${itineraryId}][]" class="form-control mb-2">
                        <button type="button" class="btn btn-danger btn-sm remove-highlight">Remove Highlight</button>
                    </div>`;
                highlightContainer.prepend(newHighlight);
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
            $(document).on('input', '.payment-amount', function () {
                updateTotalAmount();
            });

            // Add new Payment Term row
            $('.add-payment-term-row').click(function () {
                const tableBody = $('#payment-terms-section tbody');
                const newRow = `
                    <tr>
                        <input type="hidden" name="payment_term_ids[]" value="">
                        <td><input type="text" name="payment_name[]" class="form-control"></td>
                        <td><input type="number" name="payment_amount[]" class="form-control payment-amount"></td>
                        <td><button type="button" class="btn btn-danger remove-payment-term-row">Remove</button></td>
                    </tr>`;
                tableBody.append(newRow);
            });

            // Remove Payment Term row and update total amount
            $(document).on('click', '.remove-payment-term-row', function () {
                $(this).closest('tr').remove();
                updateTotalAmount();
            });

            // Initial calculation of total amount if there are existing payment terms
            updateTotalAmount();
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize CKEditor for all existing textareas
            document.querySelectorAll('.ckeditor-textarea').forEach((textarea) => {
                CKEDITOR.replace(textarea, {
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Underline'] }
                    ],
                    removeButtons: 'Italic,Strike,Subscript,Superscript'
                });
            });
        });
    </script>
@endsection

