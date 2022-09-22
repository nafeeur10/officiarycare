<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends ApiController
{
    public function store(Request $request) {
        $isValid = $this->validateDepartmentStoreRequest($request);
        if ($isValid !== true) {
            return $isValid;
        }

        $department = Department::create($request->all());
        if(!$department) return $this->respondNotTheRightParameters();
        
        return new DepartmentResource($department);
    }

    private function validateDepartmentStoreRequest(Request $request): bool {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            return $this->respondValidatorFailed($validator);
        }

        return true;
    }
}
