<?php


namespace App\Controllers;


use App\Models\DepartmentModel;

class DepartmentController extends BaseController
{
    private DepartmentModel $dep;
    function __construct()
    {
        $this->dep = new DepartmentModel();
    }

    public function createDep() {
        $data = $this->getInput();

        return $this->dep->createDep($data);
    }

    public function getDepartmentNameById($id) {
        return json_encode($this->dep->getDepartmentNameById($id));
    }

}