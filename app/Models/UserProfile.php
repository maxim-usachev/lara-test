<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    private string $lang = 'ru';

    private string $timezone = '+3';

    protected $table = 'user_profile';

    protected $fillable = [
        'lang',
        'timezone'
    ];

    /**
     * @param string $lang
     * @param string $timezone
     * @return UserProfile
     */
    public static function createForNewUser(int $userId): self
    {
        $userProfile = new self();
        $userProfile->user_id = $userId;
        $userProfile->save();
        return $userProfile;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     */
    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
