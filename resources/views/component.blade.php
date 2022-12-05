<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/js/app.js')
    </head>
    <body>
        <div class="container mt-5" id="root">
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <div class="card">
                <div class="card-body">
                    <my-component endpoint="{{ route('user.show')}}"></my-component> 
                </div>
              </div> 
            </div>
            <div class="col-4"></div>
          </div>
        </div>
    </body>
</html>
