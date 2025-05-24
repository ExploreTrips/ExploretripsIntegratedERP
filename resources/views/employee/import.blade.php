<form method="POST" enctype="multipart/form-data" id="upload_form" class="needs-validation" novalidate>
    @csrf

    <div class="modal-body py-4 px-3">
        <div class="row g-4">

            <!-- Download Sample CSV Section -->
            <div class="col-12">
                <label class="form-label fw-bold text-primary">
                    {{ __('Download Sample Employee CSV File') }}
                </label>
                <div>
                    <a href="{{ asset(Storage::url('uploads/sample') . '/sample-employee.csv') }}"
                       class="btn btn-outline-primary btn-sm">
                        <i class="ti ti-download me-1"></i> {{ __('Download') }}
                    </a>
                </div>
            </div>

            <!-- CSV Upload Section -->
            <div class="col-12">
                <label for="file" class="form-label fw-bold">
                    {{ __('Select CSV File') }}
                </label>
                <div class="input-group">
                    <input type="file" class="form-control" name="file" id="file" required>
                </div>
                {{-- <div class="form-text text-muted mt-1">
                    {{ __('Only .csv files are supported. Maximum size 2MB.') }}
                </div> --}}
                <p class="upload_file mt-2"></p>
            </div>
        </div>
    </div>

    <div class="modal-footer  border-top py-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('Cancel') }}
        </button>
        <button type="submit" class="btn btn-primary">
            <i class="ti ti-upload me-1"></i> {{ __('Upload') }}
        </button>

        <a href="#"
           data-url="{{ route('employee.import.modal') }}"
           data-ajax-popup-over="true"
           title="{{ __('Create') }}"
           data-size="xl"
           data-title="{{ __('Import Employee CSV Data') }}"
           class="d-none import_modal_show">
        </a>
    </div>
</form>



<script>
$('#upload_form').on('submit', function(event) {
        event.preventDefault();
        let data = new FormData(this);
        data.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: "#",
            method: "POST",
            data: data,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.error != '')
                {
                    show_toastr('Error',data.error, 'error');
                } else {
                    $('#commonModal').modal('hide');
                    $(".import_modal_show").trigger( "click");
                    setTimeout(function() {
                        SetData(data.output);
                    }, 700);
                }
            }
        });

    });

</script>
