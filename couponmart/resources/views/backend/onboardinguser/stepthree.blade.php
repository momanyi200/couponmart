@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mb-8 pt-16">
    <div class="w-full">
        <!-- Welcome Text -->
        <h2 class="logstitle"></h2>

        <div class="text-center">
            <h3 class="logsubs text-2xl font-semibold">KouponCity Registration Process</h3>
            <span class="text-gray-600">Step 3: Use the form below to sign up for the site</span>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto flex justify-center items-center min-h-[45vh]">
    <div class="w-full max-w-2xl">
        <form action="{{ route('saveuserstepthree') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-wrap gap-6">
                    <!-- Croppie Upload Preview -->
                    <div class="flex justify-center items-center w-[300px] h-auto mx-auto">
                        <div id="upload-demo"></div>
                    </div> 

                    <!-- File Selection -->
                    <div class="flex flex-col justify-center w-full max-w-sm space-y-4 mx-auto">
                        <strong class="text-gray-800">Select image for crop:</strong>
                        <input type="file" id="images" name="image" class="block w-full text-sm text-gray-700 border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="hidden" name="base64" id="hidden_base64" />
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded shadow hover:bg-blue-700 transition image-upload">
                            Upload Image
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
    <!-- <style>
        /* Force croppie to be centered */
        #logo_crop {
            margin-left: auto;
            margin-right: auto;
        }
    </style> -->
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });

        var resize = $('#upload-demo').croppie({
            enableExif: true,
            enableOrientation: true,
            viewport: { 
                width: 300,
                height: 300,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });

        $('#images').on('change', function () { 
            var reader = new FileReader();
            reader.onload = function (e) {
                resize.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('success bind image');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.image-upload').on('click', function (ev) { 
            resize.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (img) {
                $("#hidden_base64").val(img);			
                window.setTimeout(function() {
                    document.upload_form.submit();
                }, 1000);
            });
        });
    </script>
@endpush
@endsection
