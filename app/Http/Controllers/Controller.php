<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
  public function showSample()
  {
      return view('sample');
  }
}


