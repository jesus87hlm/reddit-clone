<?php
/**
 * Created by PhpStorm.
 * User: Jesus Hidalgo
 * Date: 5/25/2018
 * Time: 9:56 AM
 */

namespace App\Http\Controllers;


class HelloController extends Controller
{
    public function hello($name){
        return "hello ".$name;
    }
}