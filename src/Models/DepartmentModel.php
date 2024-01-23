<?php
namespace App\Models;

use  \RedBeanPHP as rb;

class DepartmentModel {

    public function getDepartmentNameById($id) {
        return rb\R::findOne('department', 'id = ? ', [$id]);
    }

    public function getAllDerartments() {
        return rb\R::findAll('department');
    }

    public function createDep($data) {
        $depDB = rb\R::dispense('department');

        $depDB->name = $data['name'];




        ;
        try{
            rb\R::store($depDB);
            echo json_encode(['status'=>"ok"]);

        } catch (\Exception $e) {
            echo json_encode(['status'=>"bad"]);
        }
    }
}