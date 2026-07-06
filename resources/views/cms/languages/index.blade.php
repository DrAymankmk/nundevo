@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#languageModal">
                        <i class="mdi mdi-plus"></i> {{ __('Add Language') }}
                    </button>
                </div>
                <h4 class="page-title">{{ __('Languages') }}</h4>
            </div>
        </div>
    </div>

    <!-- DataTable Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="languages-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Code') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Native Name') }}</th>
                                <th>{{ __('Direction') }}</th>
                                <th>{{ __('Default') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Order') }}</th>
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

<!-- Language Modal -->
<div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="languageModalLabel">{{ __('Add Language') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="languageForm">
                @csrf
                <input type="hidden" id="language_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">{{ __('Code') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="en, ar, zh-TW" required>
                            <div class="invalid-feedback" id="code-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="English" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="native_name" class="form-label">{{ __('Native Name') }}</label>
                            <input type="text" class="form-control" id="native_name" name="native_name" placeholder="العربية">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="direction" class="form-label">{{ __('Direction') }} <span class="text-danger">*</span></label>
                            <select class="form-select" id="direction" name="direction" required>
                                <option value="ltr">{{ __('LTR (Left to Right)') }}</option>
                                <option value="rtl">{{ __('RTL (Right to Left)') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="flag" class="form-label">{{ __('Flag') }}</label>
                            <input type="text" class="form-control" id="flag" name="flag" placeholder="🇺🇸 or flag-icon">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="order" class="form-label">{{ __('Order') }}</label>
                            <input type="number" class="form-control" id="order" name="order" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_default" name="is_default">
                                <label class="form-check-label" for="is_default">{{ __('Default Language') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#languages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('cms.languages.data') }}",
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'code', name: 'code' },
            { data: 'name', name: 'name' },
            { data: 'native_name', name: 'native_name' },
            { 
                data: 'direction', 
                name: 'direction',
                render: function(data) {
                    return data === 'rtl' ? '<span class="badge bg-info">RTL</span>' : '<span class="badge bg-secondary">LTR</span>';
                }
            },
            { 
                data: 'is_default', 
                name: 'is_default',
                render: function(data) {
                    return data ? '<span class="badge bg-success">{{ __("Yes") }}</span>' : '<span class="badge bg-secondary">{{ __("No") }}</span>';
                }
            },
            { 
                data: 'is_active', 
                name: 'is_active',
                render: function(data, type, row) {
                    var checked = data ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" data-id="' + row.id + '" ' + checked + '></div>';
                }
            },
            { data: 'order', name: 'order' },
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
        order: [[7, 'asc']],
        language: languages[language] || languages['en']
    });

    // Reset form when modal is closed
    $('#languageModal').on('hidden.bs.modal', function() {
        $('#languageForm')[0].reset();
        $('#language_id').val('');
        $('#languageModalLabel').text('{{ __("Add Language") }}');
        $('.is-invalid').removeClass('is-invalid');
    });

    // Form Submit
    $('#languageForm').on('submit', function(e) {
        e.preventDefault();
        
        var id = $('#language_id').val();
        var url = id ? "{{ url('cms/languages') }}/" + id : "{{ route('cms.languages.store') }}";
        var method = id ? 'PUT' : 'POST';

        var formData = {
            _token: '{{ csrf_token() }}',
            code: $('#code').val(),
            name: $('#name').val(),
            native_name: $('#native_name').val(),
            direction: $('#direction').val(),
            flag: $('#flag').val(),
            order: $('#order').val() || 0,
            is_active: $('#is_active').is(':checked') ? 1 : 0,
            is_default: $('#is_default').is(':checked') ? 1 : 0
        };

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#languageModal').modal('hide');
                    table.ajax.reload();
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
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + '-error').text(value[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("Error") }}',
                        text: xhr.responseJSON.message || '{{ __("An error occurred") }}'
                    });
                }
            }
        });
    });

    // Edit Button Click
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        
        $.get("{{ url('cms/languages') }}/" + id, function(response) {
            if (response.success) {
                var data = response.data;
                $('#language_id').val(data.id);
                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#native_name').val(data.native_name);
                $('#direction').val(data.direction);
                $('#flag').val(data.flag);
                $('#order').val(data.order);
                $('#is_active').prop('checked', data.is_active);
                $('#is_default').prop('checked', data.is_default);
                $('#languageModalLabel').text('{{ __("Edit Language") }}');
                $('#languageModal').modal('show');
            }
        });
    });

    // Delete Button Click
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: '{{ __("This action cannot be undone!") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{ __("Cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('cms/languages') }}/" + id,
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
                            text: xhr.responseJSON.message || '{{ __("An error occurred") }}'
                        });
                    }
                });
            }
        });
    });

    // Toggle Status
    $(document).on('change', '.toggle-status', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: "{{ url('cms/languages') }}/" + id + "/toggle-status",
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __("Success") }}',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                table.ajax.reload();
                Swal.fire({
                    icon: 'error',
                    title: '{{ __("Error") }}',
                    text: xhr.responseJSON.message || '{{ __("An error occurred") }}'
                });
            }
        });
    });
});
</script>
@endpush
