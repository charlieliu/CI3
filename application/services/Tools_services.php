<?php

namespace Services;

use Illuminate\Support\Collection;

class Tools_services
{
    public function __construct()
    {
    }

    public function echo_path()
    {
        return collect([
            'APPPATH' => APPPATH,
            'BASEPATH' => BASEPATH,
        ]);
    }

    public function ls()
    {
        exec('ls', $output);
        return collect($output);
    }
}