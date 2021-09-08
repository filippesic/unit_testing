<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size'];

    public function guardAgainstTooManyMembers($users)
    {
        $numberOfUsersToAdd = ($users instanceof User) ? 1 : $users->count();

        $newTeamCount = $this->count() + $numberOfUsersToAdd;

        if ($newTeamCount > $this->size) {
            throw new \Exception;
        }
    }

    public function add($users)
    {
        // Guard
        $this->guardAgainstTooManyMembers($users);

        if ($users instanceof User) return $this->members()->save($users);

        return $this->members()->saveMany($users);
    }

    public function remove($users)
    {
        if ($users instanceof User) {
            return $this->members()->where('id', $users->id)->update(['team_id' => null]);
        }

        return $this->removeMany($users);

    }

    public function removeMany($users)
    {
        return $this->members()->whereIn('id', $users->pluck('id'))->update(['team_id' => null]);
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }
}
