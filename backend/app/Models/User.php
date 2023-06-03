<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'api_token', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    
    /**
     * Listar registrar
     */
    public static function ListAll($search){
        $search = urldecode($search);
        return DB::table('users')
        ->join('user_type','user_type.id_user_type','users.id_user_type')
        ->select('users.*','user_type.name as user_type_name')
        ->where('users.state','<>',9)
        ->where(function ($query) use ($search) {
            if(!empty($search) && $search != "all"){
                $query = $query->orWhere('users.name','like',"%$search%");
                $query = $query->orWhere('users.user','like',"%$search%");
                $query = $query->orWhere('users.email','like',"%$search%");
            }
        })
        ->orderBy("users.id_user","DESC")
        ->paginate(15);
    }

    public static function GetById($id_user){
        return DB::table('users')
        ->select('users.*')
        ->where('users.id_user',$id_user)
        ->first();
    }

}
