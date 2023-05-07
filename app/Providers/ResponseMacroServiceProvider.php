<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = null,$url = null) {

            return Response::json([
              'success'  => true,
              'data' => $data,
              'url' => $url,
            ],200);
        });

        Response::macro('successMsg', function ($message = null, $url = null) {


            return Response::json([
                'success'  => true,
                'message' => $message,
                'url' => $url
              ],200);
        });


        Response::macro('redirect', function ($url) {


            return Response::json([
                'success'  => true,
                'redirection' => true,
                'url' => $url
              ],200);
        });

        Response::macro('ExceptionError', function ($message, $status = 500,$url = null) {

            return Response::json([
              'success'  => false,
              'message' => $message,
              'url' => $url,
            ], $status);
        });

        Response::macro('error', function ($message,$url = null,$status = 422) {

            return Response::json([
              'success'  => false,
              'message' => $message,
              'url' => $url
            ], $status);
        });

        Response::macro('unauthorized', function ($message,$url = null,$status = 403) {

            return Response::json([
              'success'  => false,
              'message' => $message,
              'url' => $url
            ], $status);
        });

    }
}
