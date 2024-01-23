<?php
namespace App\Models;

use  \RedBeanPHP as rb;

class DepartmentModel {

    public function getDepartmentNameById($id) {
        return rb\R::findOne('department', 'id = ? ', [$id]);
    }
}