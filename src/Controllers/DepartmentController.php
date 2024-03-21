<?php


namespace App\Controllers;


use App\Models\DepartmentModel;
use Jenssegers\Blade\Blade;

class DepartmentController extends BaseController
{
    private DepartmentModel $dep;
    private Blade $blade;
    function __construct()
    {
        $this->dep = new DepartmentModel();
        $this->blade = new Blade('src/views','src/cache');
    }

    public function createDep() {
        $data = $this->getInput();

        return $this->dep->createDep($data);
    }

    public function getDepartmentNameById($id) {
        return json_encode($this->dep->getDepartmentNameById($id));
    }

    public function getAllDepartments() {
        return $this->blade->make('dep', ['title'=>'Отделы','navbar_show'=>true, 'deps'=>
            (new DepartmentModel())->getAllDerartments()])->render();
    }

}