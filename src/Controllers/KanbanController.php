<?php


namespace App\Controllers;
use Jenssegers\Blade\Blade;

use App\Models\kanbanModel;

class KanbanController
{

    private kanbanModel $kanbanModel;
    private Blade $blade;
    public function __construct()
    {
        $this->kanbanModel = new kanbanModel();
        $this->blade = new Blade('src/views','src/cache');
    }


    public function getPrepareRefs() {
        $kanbanList = $this->kanbanModel->getAllBoards();
        return $this->blade->make('kanbanRefresh', ['title'=>'Редактирование Канбана','navbar_show'=>true, 'boards'=>$kanbanList])->render();
    }

}