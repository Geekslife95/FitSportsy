<?php
namespace App\Services;
use App\Models\User as ModelsUser;

class User{
    public static function getOrganisers(){
        $users = ModelsUser::role('Organizer')->select('id','first_name','last_name')->orderBy('id', 'DESC')->get();
        return $users;
    }
}