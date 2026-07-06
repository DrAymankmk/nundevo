@extends('layout_new.mainlayout')

@section('content')
    <div  class="page-wrapper" style="padding:10px">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button type="button" class="btn btn-success me-2" id="scanBtn">
                        <i class="mdi mdi-magnify-scan"></i> {{ __('Scan Translations') }}
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#translationModal">
                        <i class="mdi mdi-plus"></i> {{ __('Add Translation') }}
                    </button>
                </div>
                <h4 class="page-title">{{ __('Translations') }}</h4>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter Row -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select id="filterLocale" class="form-select">
                <option value="">{{ __('All Locales') }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <select id="filterFile" class="form-select">
                <option value="">{{ __('All Files') }}</option>
            </select>
        </div>
    </div>

    <!-- DataTable Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="translations-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('Locale') }}</th>
                                <th>{{ __('File') }}</th>
                                <th>{{ __('Key') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('File Path') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Translation Modal -->
<div class="modal fade" id="translationModal" tabindex="-1" aria-labelledby="translationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="translationModalLabel">{{ __('Add Translation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="translationForm">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="translation_id" id="translationId" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="locale" class="form-label">{{ __('Locale') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="locale" name="locale" required>
                                    <option value="">{{ __('Select Locale') }}</option>
                                </select>
                                <div class="mt-2">
                                    <input type="text" class="form-control form-control-sm" id="newLocale" placeholder="{{ __('Or enter new locale (e.g., fr, de)') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="file" class="form-label">{{ __('File') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="file" name="file" required>
                                    <option value="">{{ __('Select File') }}</option>
                                </select>
                                <div class="mt-2">
                                    <input type="text" class="form-control form-control-sm" id="newFile" placeholder="{{ __('Or enter new file name (e.g., auth, validation)') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="key" class="form-label">{{ __('Key') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="key" name="key" required placeholder="{{ __('e.g., welcome_message or auth.login') }}">
                        <small class="text-muted">{{ __('Use dot notation for nested keys (e.g., auth.login.title)') }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">{{ __('Value') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="value" name="value" rows="4" required placeholder="{{ __('Translation value') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Load locales and files for filters and form
    loadLocales();
    loadFiles();

    var table = $('#translations-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('cms.translations.data') }}",
            type: 'GET',
            data: function(d) {
                d.filterLocale = $('#filterLocale').val();
                d.filterFile = $('#filterFile').val();
            }
        },
        columns: [
            { 
                data: 'locale', 
                name: 'locale',
                render: function(data) {
                    return '<span class="badge bg-primary">' + data + '</span>';
                }
            },
            { 
                data: 'file', 
                name: 'file',
                render: function(data) {
                    var label = data === '_json' ? 'JSON ({{ __("Main") }})' : data;
                    var badgeClass = data === '_json' ? 'bg-success' : 'bg-info';
                    return '<span class="badge ' + badgeClass + '">' + label + '</span>';
                }
            },
            { data: 'key', name: 'key' },
            { 
                data: 'value', 
                name: 'value',
                render: function(data) {
                    if (data && data.length > 50) {
                        return '<span title="' + $('<div/>').text(data).html() + '">' + data.substring(0, 50) + '...</span>';
                    }
                    return data;
                }
            },
            { data: 'file_path', name: 'file_path' },
            {
                data: null,
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info edit-btn" data-id="${row.id}">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[2, 'asc']],
        language: languages[language] || languages['en']
    });

    // Filter change events
    $('#filterLocale, #filterFile').on('change', function() {
        table.ajax.reload();
    });

    // Load locales for dropdown
    function loadLocales() {
        $.get("{{ route('cms.translations.locales') }}", function(data) {
            var options = '<option value="">{{ __("Select Locale") }}</option>';
            var filterOptions = '<option value="">{{ __("All Locales") }}</option>';
            data.forEach(function(locale) {
                options += '<option value="' + locale + '">' + locale + '</option>';
                filterOptions += '<option value="' + locale + '">' + locale + '</option>';
            });
            $('#locale').html(options);
            $('#filterLocale').html(filterOptions);
        });
    }

    // Load files for dropdown
    function loadFiles() {
        $.get("{{ route('cms.translations.files') }}", function(data) {
            var options = '<option value="">{{ __("Select File") }}</option>';
            var filterOptions = '<option value="">{{ __("All Files") }}</option>';
            data.forEach(function(file) {
                var label = file === '_json' ? 'JSON ({{ __("Main") }})' : file;
                options += '<option value="' + file + '">' + label + '</option>';
                filterOptions += '<option value="' + file + '">' + label + '</option>';
            });
            $('#file').html(options);
            $('#filterFile').html(filterOptions);
        });
    }

    // Handle new locale input
    $('#newLocale').on('input', function() {
        var val = $(this).val().trim();
        if (val) {
            $('#locale').val('');
            $('#locale').prop('disabled', true);
        } else {
            $('#locale').prop('disabled', false);
        }
    });

    // Handle new file input
    $('#newFile').on('input', function() {
        var val = $(this).val().trim();
        if (val) {
            $('#file').val('');
            $('#file').prop('disabled', true);
        } else {
            $('#file').prop('disabled', false);
        }
    });

    // Reset modal on close
    $('#translationModal').on('hidden.bs.modal', function() {
        $('#translationForm')[0].reset();
        $('#translationId').val('');
        $('#formMethod').val('POST');
        $('#translationModalLabel').text('{{ __("Add Translation") }}');
        $('#locale').prop('disabled', false);
        $('#file').prop('disabled', false);
        $('#newLocale').val('');
        $('#newFile').val('');
    });

    // Form submission
    $('#translationForm').on('submit', function(e) {
        e.preventDefault();
        
        var translationId = $('#translationId').val();
        var method = translationId ? 'PUT' : 'POST';
        var url = translationId 
            ? "{{ url('cms/translations') }}/" + translationId 
            : "{{ route('cms.translations.store') }}";

        // Get locale and file values
        var locale = $('#newLocale').val().trim() || $('#locale').val();
        var file = $('#newFile').val().trim() || $('#file').val();

        if (!locale || !file) {
            Swal.fire({
                icon: 'error',
                title: '{{ __("Error") }}',
                text: '{{ __("Please select or enter a locale and file") }}'
            });
            return;
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: '{{ csrf_token() }}',
                locale: locale,
                file: file,
                key: $('#key').val(),
                value: $('#value').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#translationModal').modal('hide');
                    table.ajax.reload();
                    loadLocales();
                    loadFiles();
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Success") }}',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                var errorMessage = '';
                if (errors) {
                    Object.keys(errors).forEach(function(key) {
                        errorMessage += errors[key].join('<br>') + '<br>';
                    });
                } else {
                    errorMessage = xhr.responseJSON?.message || '{{ __("An error occurred") }}';
                }
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Error") }}',
                    html: errorMessage
                });
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        // Decode the base64 ID to get locale, file, key
        var decoded = atob(id).split('|');
        var locale = decoded[0];
        var file = decoded[1];
        var key = decoded[2];

        // Get the value from the table row
        var row = table.row($(this).closest('tr')).data();
        
        $('#translationId').val(id);
        $('#formMethod').val('PUT');
        $('#translationModalLabel').text('{{ __("Edit Translation") }}');
        
        // Set form values
        setTimeout(function() {
            $('#locale').val(locale);
            $('#file').val(file);
            $('#key').val(key);
            $('#value').val(row.value);
        }, 100);
        
        $('#translationModal').modal('show');
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: '{{ __("This translation will be deleted!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{ __("Cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('cms/translations') }}/" + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __("Deleted!") }}',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __("Error") }}',
                            text: xhr.responseJSON?.message || '{{ __("An error occurred") }}'
                        });
                    }
                });
            }
        });
    });

    // Scan translations button
    $('#scanBtn').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> {{ __("Scanning...") }}');
        
        $.ajax({
            url: "{{ route('cms.translations.scan') }}",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                btn.prop('disabled', false).html('<i class="mdi mdi-magnify-scan"></i> {{ __("Scan Translations") }}');
                if (response.success) {
                    table.ajax.reload();
                    loadLocales();
                    loadFiles();
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Scan Complete") }}',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="mdi mdi-magnify-scan"></i> {{ __("Scan Translations") }}');
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Error") }}',
                    text: xhr.responseJSON?.message || '{{ __("An error occurred") }}'
                });
            }
        });
    });
});
</script>
@endpush
