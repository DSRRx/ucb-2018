<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UsersRole;

class UsersRoleController extends Controller
{

    public function index () {
      $users = User::all ();
      return view ('users.index', compact ('users'));
    }

    public function makeMeUser () {
      $myId = Auth::id ();
      $t_users_role = new UsersRole;
      $t_users_role->id_user = $myId;
      $t_users_role->id_role = '2';
      $t_users_role-> save ();
      return redirect()->route('/', [$param]);
    }

    public function makeItAdmin ($id) {
      $t_users_role = new UsersRole;
      $t_users_role->id_user = $id;
      $t_users_role->id_role = '1';
      $t_users_role-> save ();
      return view ('users.index', compact ('users'));
    }

    public function makeItOwner ($id) {
      $t_users_role = new UsersRole;
      $t_users_role->id_user = $id;
      $t_users_role->id_role = '3';
      $t_users_role-> save ();
      return view ('users.index', compact ('users'));
    }

    public function createAdmin () {

    }

    public function createUser () {

    }

    public function createOwner () {

    }

    public function store (Request $request) {

    }

    public function show ($id) {

    }

    public function edit ($id) {

    }

    public function update (Request $request, $id) {

    }

    public function destroy ($id) {

    }
}
