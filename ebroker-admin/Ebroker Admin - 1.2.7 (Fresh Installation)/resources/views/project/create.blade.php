@extends('layouts.main')

@section('title')
    {{ __('Add Project') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/map-responsive.css') }}">
@endsection
<!-- add before </body> -->

{{-- <script src="https://unpkg.com/filepond/dist/filepond.js"></script> --}}
@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('project.index') }}" id="subURL">{{ __('View Project') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ __('Add') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {!! Form::open(['route' => 'project.store', 'data-parsley-validate', 'id' => 'create-form', 'files' => true,'data-success-function'=> "formSuccessFunction"]) !!}
    <div class='row'>
        <div class='col-md-6'>
            <div class="card">
                <h3 class="card-header"> {{ __('Details') }}</h3>
                <hr>
                <input type="hidden" id="default-latitude" value="{{ system_setting('latitude') }}">
                <input type="hidden" id="default-longitude" value="{{ system_setting('longitude') }}">

                {{-- Category --}}
                <div class="card-body">
                    <div class="col-md-12 col-12 form-group mandatory">
                        {{ Form::label('category', __('Category'), ['class' => 'form-label col-12 ']) }}
                        <select name="category_id" class="form-select form-control-sm" data-parsley-minSelect='1' id="project-category" required>
                            <option value="" selected>{{ __('Choose Category') }}</option>
                            @foreach ($category as $row)
                                <option value="{{ $row->id }}" data-parametertypes='{{ $row->parameter_types }}'>
                                    {{ $row->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Title --}}
                    <div class="col-md-12 col-12 form-group mandatory">
                        {{ Form::label('title', __('Title'), ['class' => 'form-label col-12 ']) }}
                        {{ Form::text('title', '', [ 'class' => 'form-control ', 'placeholder' =>  __('Title'), 'required' => 'true', 'id' => 'title', ]) }}
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-12 col-12 form-group">
                        {{ Form::label('slug', __('Slug'), ['class' => 'form-label col-12 ']) }}
                        {{ Form::text('slug', '', [ 'class' => 'form-control ', 'placeholder' =>  __('Slug'), 'id' => 'slug', ]) }}
                        <small class="text-danger text-sm">{{ __("Only Small English Characters, Numbers And Hypens Allowed") }}</small>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12 col-12 form-group mandatory">
                        {{ Form::label('description', __('Description'), ['class' => 'form-label col-12 ']) }}
                        {{ Form::textarea('description', '', [ 'class' => 'form-control mb-3', 'rows' => '5', 'id' => '', 'required' => 'true', 'placeholder' => __('Description') ]) }}
                    </div>

                    {{-- Project Type --}}
                    <div class="col-md-12 col-12  form-group  mandatory">
                        <div class="row">
                            {{ Form::label('', __('Project Type'), ['class' => 'form-label col-12 ']) }}

                            {{-- Upcoming --}}
                            <div class="col-md-6">
                                {{ Form::radio('project_type', 'upcoming', null, [ 'class' => 'form-check-input', 'id' => 'upcoming', 'required' => true, 'checked' => true ]) }}
                                {{ Form::label('project_type', __('Upcoming'), ['class' => 'form-check-label','for' => 'upcoming']) }}
                            </div>

                            {{-- Under Construction --}}
                            <div class="col-md-6">
                                {{ Form::radio('project_type', 'under_construction', null, [ 'class' => 'form-check-input', 'id' => 'under_construction', 'required' => true, ]) }}
                                {{ Form::label('project_type', __('Under Construction'), ['class' => 'form-check-label','for' => 'under_construction']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="card">
                <h3 class="card-header">{{ __('SEO Details') }}</h3>
                <hr>
                <div class="row card-body">

                    {{-- SEO Title --}}
                    <div class="col-12 form-group">
                        {{ Form::label('title', __('Title'), ['class' => 'form-label text-center']) }}
                        <textarea id="meta_title" name="meta_title" class="form-control" rows="2" style="height: 75px" placeholder="{{ __('Title') }}"></textarea>
                        <span class="small text-muted">{{ __("Recommended: 55-60 characters, Max size: 255 characters") }}</span>
                        <br>
                    </div>

                    {{-- SEO Image --}}
                    <div class="col-12 form-group card">
                        {{ Form::label('meta_image', __('Image'), ['class' => 'form-label']) }}
                        <input type="file" name="meta_image" id="meta_image" class="filepond from-control" placeholder="{{ __('Image') }}">
                        <span class="small text-muted">{{ __("Allowed: JPG, PNG, JPEG, Max size: 5MB") }}</span>
                        <div class="img_error"></div>
                    </div>

                    {{-- SEO Description --}}
                    <div class="col-12 form-group">
                        {{ Form::label('description', __('Description'), ['class' => 'form-label text-center']) }}
                        <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="{{ __('Description') }}"></textarea>
                        <span class="small text-muted">{{ __("Recommended: 155-160 characters, Max size: 255 characters") }}</span>
                        <br>
                    </div>

                    {{-- SEO Keywords --}}
                    <div class="col-12 form-group">
                        {{ Form::label('keywords', __('Keywords'), ['class' => 'form-label']) }}
                        <textarea name="keywords" id="" class="form-control" rows="3" placeholder="{{ __('Keywords') }}"></textarea>
                        <span class="small text-muted">{{ __("Max size: 255 characters") }}</span>
                        (add comma separated keywords)
                    </div>

                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class='col-md-12'>
            <div class="card">
                <h3 class="card-header">{{ __('Location') }}</h3>
                <hr>
                <div class="card-body">

                    <div class="row">
                        <div class='col-md-6'>
                            <div class="card col-md-12" id="map" style="height: 400px; min-height: 300px;">
                                <!-- Google map -->
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="row">
                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('city', __('City'), ['class' => 'form-label col-12 ']) }}
                                    {!! Form::hidden('city', '', ['class' => 'form-control ', 'id' => 'city']) !!}
                                    <input id="searchInput" class="controls form-control" type="text" placeholder="{{ __('City') }}" required>
                                    {{-- {{ Form::text('city', '', ['class' => 'form-control ', 'placeholder' => 'City', 'id' => 'city', 'required' => true]) }} --}}
                                </div>
                                <div class="col-md-6 form-group mandatory">
                                    {{ Form::label('country', __('Country'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::text('country', '', ['class' => 'form-control ', 'placeholder' => __('Country'), 'id' => 'country', 'required' => true]) }}
                                </div>
                                <div class="col-md-6 form-group mandatory">
                                    {{ Form::label('state', __('State'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::text('state', '', ['class' => 'form-control ', 'placeholder' => __('State'), 'id' => 'state', 'required' => true]) }}
                                </div>
                                <div class="col-md-6 form-group mandatory">
                                    {{ Form::label('latitude', __('Latitude'), ['class' => 'form-label col-12 ']) }}
                                    {!! Form::text('latitude', '', ['class' => 'form-control', 'id' => 'latitude', 'step' => 'any', 'readonly' => true, 'required' => true, 'placeholder' => __('Latitude')]) !!}
                                </div>
                                <div class="col-md-6 form-group mandatory">
                                    {{ Form::label('longitude', __('Longitude'), ['class' => 'form-label col-12 ']) }}
                                    {!! Form::text('longitude', '', ['class' => 'form-control', 'id' => 'longitude', 'step' => 'any', 'readonly' => true, 'required' => true, 'placeholder' => __('Longitude')]) !!}
                                </div>
                                <div class="col-md-12 col-12 form-group mandatory">
                                    {{ Form::label('address', __('Address'), ['class' => 'form-label col-12 ']) }}
                                    {{ Form::textarea('address', '', [
                                        'class' => 'form-control ',
                                        'placeholder' => __('Address'),
                                        'rows' => '4',
                                        'id' => 'address',
                                        'autocomplete' => 'off',
                                        'required' => 'true',
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Floor Plans --}}
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">{{ __('Floor Plans') }}</h3>
                <hr>
                <div class="card-body projects-floor-plans">
                    {{-- Floor Section --}}
                    <div class="mt-4" data-repeater-list="floor_data">
                        <div class="row floor-section" data-repeater-item>
                            {{-- Floor Title --}}
                            <div class="form-group col-md-5">
                                <label class="form-label">{{ __('Floor') }} - <span class="floor-number">1</span> <span class="text-danger">*</span></label>
                                <input type="text" name="title" placeholder="{{__('Enter Floor Title')}}" class="form-control" required>
                            </div>

                            {{-- Floor Image --}}
                            <div class="form-group col-md-6">
                                {{ Form::label('floor-image', __('Floor Image'), ['class' => 'form-label']) }}
                                <input type="file" class="form-control" name="floor_image" accept="image/jpg,image/png,image/jpeg" required>
                            </div>
                            <div class="form-group col-md-1 pl-0 mt-4">
                                <button data-repeater-delete type="button" class="btn btn-icon btn-danger remove-default-floor" title="{{__('Remove Floor')}}">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- Add New Floor Button --}}
                    <div class="col-md-5 pl-0 mb-4">
                        <button type="button" class="btn btn-success add-new-floor" data-repeater-create title="{{__('Add New Floor')}}">
                            <span><i class="fa fa-plus"></i> {{__('Add New Floor')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Images, Videos and Documents --}}
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">{{ __('Images, Videos and Documents') }}</h3>
                <hr>
                <div class="card-body">
                    <div class="row">
                        {{-- Title Image --}}
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3  form-group mandatory">
                            {{ Form::label('title-image', __('Title Image'), ['class' => 'form-label']) }}
                            <input type="file" class="filepond" id="title-image" name="image" accept="image/jpg,image/png,image/jpeg" required>
                        </div>

                        {{-- Gallery Images --}}
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            {{ Form::label('gallary-images', __('Gallery Images'), ['class' => 'form-label']) }}
                            <input type="file" class="filepond" id="gallary-images" name="gallery_images[]" multiple accept="image/jpg,image/png,image/jpeg">
                        </div>

                        {{-- Documents --}}
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            {{ Form::label('documents', __('Documents'), ['class' => 'form-label ']) }}
                            <input type="file" class="filepond" id="documents" name="documents[]" multiple accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        </div>

                        {{-- Video Link --}}
                        <div class="col-md-3">
                            {{ Form::label('video_link', __('Video Link'), ['class' => 'form-label']) }}
                            {{ Form::text('video_link', isset($list->video_link) ? $list->video_link : '', [ 'class' => 'form-control ', 'placeholder' => trans('Video Link'), 'id' => 'address', 'autocomplete' => 'off', ]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($languages) && $languages->count() > 0)
            {{-- Translations Div --}}
            <div class="translation-div">
                <div class="card">
                    <h3 class="card-header">{{ __('Translations for Project') }}</h3>
                    <hr>
                    <div class="card-body">
                        {{-- Fields for Translations --}}
                        @foreach($languages as $key =>$language)
                            <div class="bg-light p-3 mt-2 rounded">
                                <h5 class="text-center">{{ $language->name }}</h5>
                                <label for="translation-title-{{ $language->id }}">{{ __('Title') }}</label>
                                <div class="form-group">
                                    <input type="hidden" name="translations[{{ $key }}][title][language_id]" value="{{ $language->id }}">
                                    <input type="text" name="translations[{{ $key }}][title][value]" id="translation-title-{{ $language->id }}" class="form-control" placeholder="{{ __('Enter Title') }}">
                                </div>
                                <label for="translation-description-{{ $language->id }}">{{ __('Description') }}</label>
                                <div class="form-group">
                                    <input type="hidden" name="translations[{{ $key }}][description][language_id]" value="{{ $language->id }}">
                                    <textarea name="translations[{{ $key }}][description][value]" id="translation-description-{{ $language->id }}" class="form-control" placeholder="{{ __('Enter Description') }}"></textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        {{-- Save --}}
        <div class='col-md-12 d-flex justify-content-end mb-3'>
            <input type="submit" class="btn btn-primary" value="{{ __('Save') }}"> &nbsp;&nbsp;
            <button class="btn btn-secondary" type="button" onclick="myForm.reset();">{{ __('Reset') }}</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
@section('script')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer></script>
    <script src="{{ asset('assets/js/maps-helper.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            initMap();
        });

        function initMap() {
            window.initBackendPlacesMap({
                mapElementId: 'map',
                inputSelector: '#searchInput',
                citySelector: '#city',
                countrySelector: '#country',
                stateSelector: '#state',
                addressSelector: '#address',
                latitudeSelector: '#latitude',
                longitudeSelector: '#longitude',
                defaultLatitudeSelector: '#default-latitude',
                defaultLongitudeSelector: '#default-longitude'
            });
        }
        jQuery(document).ready(function() {
            initMap();
            $('.select2').prepend('<option value="" selected></option>');

        });
        $(document).ready(function() {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize,FilePondPluginFileValidateType);
        });

        $("#title").on('keyup',function(e){
            let title = $(this).val();
            let slugElement = $("#slug");
            if(title){
                $.ajax({
                    type: 'POST',
                    url: "{{ route('project.generate-slug') }}",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        title: title
                    },
                    beforeSend: function() {
                        slugElement.attr('readonly', true).val('Please wait....')
                    },
                    success: function(response) {
                        if(!response.error){
                            if(response.data){
                                slugElement.removeAttr('readonly').val(response.data);
                            }else{
                                slugElement.removeAttr('readonly').val("")
                            }
                        }
                    }
                });
            }else{
                slugElement.removeAttr('readonly', true).val("")
            }
        });

        function formSuccessFunction(response) {
            if(!response.error){
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }
    </script>
@endsection
