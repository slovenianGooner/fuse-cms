<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lab404\Impersonate\Controllers\ImpersonateController as BaseImpersonateController;

class ImpersonateController extends BaseImpersonateController
{
    public function take(Request $request, $id, $guardName = null)
    {
        if (!$request->user()->can('impersonate')) {
            abort(403);
        }

        return parent::take($request, $id, $guardName);
    }
}
