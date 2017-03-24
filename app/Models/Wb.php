<?php
/**
 * Created by PhpStorm.
 * User: Jason.z
 * Date: 2017/3/24
 * Time: 上午9:23
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wb extends Model
{
    protected $table = 'weibo';

    protected $casts = [
        'config' => 'array',
    ];

}
