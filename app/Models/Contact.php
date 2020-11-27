<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public static $columnsMap = [
        'team_id' => 'Team ID',
        'name'    => 'Name',
        'phone'   => 'Phone',
        'email'   => 'Email',
        'sticky_phone_number_id' => 'Sticky Phone Number ID',
    ];
}
