<?php

namespace App\Models;

use App\Models\Staff\PersonalTrainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CheckInNonPersonalTrainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'pt_id',
        'check_in_time',
        'check_out_time',
        'user_id'
    ];

    protected $hidden = [];
    
    public function personalTrainer()
    {
        return $this->belongsTo(PersonalTrainer::class, 'pt_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function checkInNonPT($pt_code = "", $personal_trainer_id = "")
    {
        $sql = "SELECT * FROM personal_trainers where" . ($pt_code ? " personal_trainers.pt_code='$pt_code' " : '') . ($personal_trainer_id ? "and personal_trainers.id='$personal_trainer_id' " : '');
        $activeTrainerSessions = DB::select($sql);

        return $activeTrainerSessions;
    }

    public static function detailNonPT($pt_code = "", $personal_trainer_id = "")
    {
        $sql = "SELECT * FROM personal_trainers where" . ($pt_code ? " personal_trainers.pt_code='$pt_code' " : '') . ($personal_trainer_id ? "and personal_trainers.id='$personal_trainer_id' " : '');
        $activeTrainerSessions = DB::select($sql);

        return $activeTrainerSessions;
    }
}
