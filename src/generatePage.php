<?php

namespace App;

class generatePage
{
    protected $header;
    protected $body;
    protected $footer;
    public function buildPage($hbody, $title)
    {
        $this->header = file_get_contents('src/template/header.php');
        $this->footer = file_get_contents("src/template/footer.php");
        $this->body = file_get_contents("src/template/".$hbody);

        $this->header = str_replace('</title>', '<title>'.$title.'</title>', $this->header);

    }





}