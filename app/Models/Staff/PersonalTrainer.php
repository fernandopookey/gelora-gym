<?php

namespace App\Models\Staff;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PersonalTrainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'role',
        'phone_number',
        'address',
        'description',
        'user_id',
        'type',
        'pt_code'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public static function checkInNonPT($pt_code = "")
    // {
    //     $sql = "SELECT * FROM personal_trainers where" . ($pt_code ? " personal_trainers.pt_code='$pt_code' " : '');
    //     $activeTrainerSessions = DB::select($sql);

    //     return $activeTrainerSessions;
    // }


    public static function checkInNonPT($pt_code = "")
    {
        $sql = "SELECT pt.id, pt.full_name, pt.pt_code, cits_view.current_check_in_trainer_sessions_id, cits_view.check_in_time, cits_view.check_out_time, cits_view.updated_at_check_in
                FROM personal_trainers pt

                LEFT JOIN check_in_non_personal_trainers cinpt on pt.id = cinpt.pt_id

                LEFT JOIN (select cinpt1.id as current_check_in_trainer_sessions_id, cinpt1.updated_at AS 
                updated_at_check_in, cinpt1.pt_id, cinpt1.check_in_time, cinpt1.check_out_time from check_in_non_personal_trainers cinpt1

                INNER JOIN (SELECT max(id) as max_id FROM check_in_non_personal_trainers group by pt_id) as cinpt2 on cinpt1.id=cinpt2.max_id) as cits_view on cits_view.pt_id = pt.id
                
                where " . ($pt_code ? " pt.pt_code='$pt_code' " : '');
                $activeTrainerSessions = DB::select($sql);

        return $activeTrainerSessions;
    }

    // public static function detailCheckInNonPT($pt_id = "")
    // {
    //     $sql = "SELECT pt.id, pt.full_name, pt.pt_code, cits_view.current_check_in_trainer_sessions_id, cits_view.check_in_time, cits_view.check_out_time, cits_view.updated_at_check_in
    //             FROM personal_trainers pt

    //             LEFT JOIN check_in_non_personal_trainers cinpt on pt.id = cinpt.pt_id

    //             LEFT JOIN (select cinpt1.id as current_check_in_trainer_sessions_id, cinpt1.updated_at AS 
    //             updated_at_check_in, cinpt1.pt_id, cinpt1.check_in_time, cinpt1.check_out_time from check_in_non_personal_trainers cinpt1

    //             INNER JOIN (SELECT max(id) as max_id FROM check_in_non_personal_trainers group by pt_id) as cinpt2 on cinpt1.id=cinpt2.max_id) as cits_view on cits_view.pt_id = pt.id
                
    //             where " . ($pt_id ? " pt.id='$pt_id' " : '');
    //             $activeTrainerSessions = DB::select($sql);
    //             // dd($sql);

    //     return $activeTrainerSessions;
    // }

    // public static function detailCheckInNonPT($pt_id = "")
    // {
    //     $sql = "SELECT pt.id, pt.full_name, pt.pt_code, cits_view.current_check_in_trainer_sessions_id, cits_view.check_in_time, cits_view.check_out_time, cits_view.updated_at_check_in
    //             FROM personal_trainers pt

    //             LEFT JOIN check_in_non_personal_trainers cinpt on pt.id = cinpt.pt_id

    //             LEFT JOIN (select cinpt1.id as current_check_in_trainer_sessions_id, cinpt1.updated_at AS 
    //             updated_at_check_in, cinpt1.pt_id, cinpt1.check_in_time, cinpt1.check_out_time from check_in_non_personal_trainers cinpt1

    //             INNER JOIN (SELECT max(id) as max_id FROM check_in_non_personal_trainers group by pt_id) as cinpt2 on cinpt1.id=cinpt2.max_id) as cits_view on cits_view.pt_id = pt.id
                
    //             where " . ($pt_id ? " pt.id='$pt_id' " : '');
     
    //             $activeTrainerSessions = DB::select($sql);
    //             // dd($sql);

    //     return $activeTrainerSessions;
    // }

    public static function test($pt_id = "")
    {
        $sql = "SELECT cinpt.pt_id, cinpt.check_in_time, cinpt.check_out_time FROM check_in_non_personal_trainers cinpt

                LEFT JOIN personal_trainers pt ON pt.id = cinpt.pt_id
                
                where " . ($pt_id ? " pt.id='$pt_id' " : '');
     
                $activeTrainerSessions = DB::select($sql);
                // dd($sql);

        return $activeTrainerSessions;
    }
}
