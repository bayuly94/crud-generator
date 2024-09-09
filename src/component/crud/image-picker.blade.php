<div class="form-group mb-2 mb20">
    <label for="image" class="form-label">{{ $label }}</label>
    <div class="input-group mb-3">
        <input type="text" readonly name="{{ $field }}" id="{{ $field }}" 
            class="form-control bg-white @error($field) is-invalid @enderror" value="{{ old($field, $value) }}"
            placeholder="{{ $label }}">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" id="{{ $field }}_picker" type="button">Pilih</button>
        </div>
    </div>


    {!! $errors->first($field, '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}

    <!-- Modal -->
    <div class="modal fade" id="{{ $field }}_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" id="{{ $field }}_file" accept=".jpg,.png" />
                    <div>File .jpg, .png</div>
                    <div id="{{ $field }}_upload_progress"></div>
                </div>
                <div class="modal-footer">

                    <button type="button" id="{{ $field }}_picker_upload" class="btn btn-primary">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    // Get the input element
    const input = document.getElementById('{{ $field }}_picker');
    const pickerUpload = document.getElementById('{{ $field }}_picker_upload');

    var modal = $('#{{ $field }}_modal');

    // Add a click event listener
    input.addEventListener('click', function() {
        modal.modal('show');
    });



    pickerUpload.addEventListener('click', function() {
        var fileInput = $("#{{ $field }}_file")[0];
        var file = fileInput.files[0];

        if (file) {

            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('file', file);
            formData.append('folder', '{{ $folder }}');

            // jQuery AJAX call
            $.ajax({
                url: "{{ route('upload') }}", // Your server-side upload URL
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from converting the data into a query string
                contentType: false, // Prevent jQuery from setting a default content-type
                success: function(response) {
                    // alert('Image uploaded successfully!');
                    console.log(response);

                    if (response.file != null) {
                        $("#{{ $field }}").val(response.file);

                        modal.modal('hide');
                    }
                },
                error: function(response) {
                    alert('Failed to upload the image.');
                    console.log(response);
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    
                    // Upload progress
                    xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        console.log("Upload progress: " + percentComplete + "%");
                        // You can update a progress bar here
                        $("#{{ $field }}_upload_progress").html("Upload progress: " + percentComplete + "%");
                    }
                    }, false);
                    return xhr;
                },
            });
        }
    });
</script>
@endsection
