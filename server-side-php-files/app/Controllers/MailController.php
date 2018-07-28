<?php
declare (strict_types = 1);

namespace App\Controllers;

use Framework\Http\Controller;
use Framework\Http\Request;

class MailController extends Controller
{
    private $dataBase;

    private $labelId = [
        'inbox' => 1,
        'trash' => 2,
        'spam' => 3,
        'social' => 4,
        'promotion' => 5,
        'forum' => 6,
        'update' => 7
    ];

    public function __construct(MailDataBaseController $dataBase)
    {
        $this->dataBase = $dataBase;
    }

    public function getMail(Request $request) : string
    {
        $box = $request->getParameter('box');
        $result = $this->dataBase->getMail($this->labelId[$box]);

        return json_encode($result);
    }

    public function unreadMail() : string
    {
        $boxes = $_GET['boxes'];
        $parsedJSON = json_decode($boxes);

        foreach ($parsedJSON as $key => &$value) {
            $value = $this->dataBase->getUnreadMail($this->labelId[$key])[0][0]; // [0][0] should be changed
        }

        return json_encode($parsedJSON);
    }

    public function transferMail() : bool
    {
        $from = $_GET['transferFrom'];
        $to = $_GET['transferTo'];
        $id = $_GET['id'];
        $stringOfIds = implode(",", $id);
        
        return $this->dataBase->transferMail($this->labelId[$to], $from, $stringOfIds);
    }

}
