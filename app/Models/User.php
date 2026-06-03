<?php

namespace App\Models;

use App\Enums\RoleType;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
        'id_branch',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role')->withTrashed();
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'id_branch', 'id_branch')->withTrashed();
    }

    public function isSuperAdmin(): bool
    {
        return RoleType::tryFromId($this->id_role) === RoleType::SuperAdmin;
    }

    public function roleType(): ?RoleType
    {
        return RoleType::tryFromId($this->id_role);
    }

    public function isOperatorProduksi(): bool
    {
        return RoleType::tryFromId($this->id_role) === RoleType::OperatorProduksi;
    }

    public function isKepalaCabang(): bool
    {
        return RoleType::tryFromId($this->id_role) === RoleType::KepalaCabang;
    }

    public function canAccessBranchProduction(): bool
    {
        return $this->isOperatorProduksi() || $this->isKepalaCabang();
    }

    public function isAdminPusat(): bool
    {
        return RoleType::tryFromId($this->id_role) === RoleType::AdminPusat;
    }
}
