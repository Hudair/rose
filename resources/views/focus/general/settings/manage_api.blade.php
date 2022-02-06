@extends ('core.layouts.app')
@section ('title', 'Manage API')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">Laravel Passport OAuth2 server implementation</h4>

                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body text-left">
                        <div class="card-block"><h4>About API Driver</h4>

                            <hr>
                            <h6>Laravel Passport Version 10.1</h6>
                            <hr>
                            <p>Laravel Passport provides a full OAuth2 server implementation for your Laravel application in a matter of minutes. </p>
                            <p>To consume it, intermediate Passport Skills Required.</p>
                            <hr>
                           <p> Ready to build, create you passport client using the command terminal</p>
                            <pre>
                                php artisan passport:client --personal
                            </pre>

                            <p>Later write your code for modules and set routes for api calls using  <strong>api:auth</strong> middleware</p>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('after-scripts')
    {{ Html::script('focus/js/loading-bar.js') }}
    <script>
        $(document).on('click', "#download_update", function (e) {
            e.preventDefault();
            var bar1 = new ldBar("#ldBar");

            setInterval(function () {
                bar1.set(Math.floor((Math.random() * 70) + 30));
            }, 2000);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('biller.download_update')}}',
                dataType: 'html',
                method: 'POST',
                data: {
                    'v': '5'
                },
                success: function (data) {
                    $('#step1').html(data);
                    var bar1 = new ldBar("#ldBar2");
                    bar1.set(100);
                    //     $('#step1').hide();
                    $('#step2').show();
                }
            });

        });


    </script>

@endsection
