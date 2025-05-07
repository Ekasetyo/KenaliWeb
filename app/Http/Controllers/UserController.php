<?php
// filepath: c:\xampp\htdocs\FinomalyWeb\app\Http\Controllers\UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('dashboard-form.user');
    }
}