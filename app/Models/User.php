<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Proposal;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a normal user/petani.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isUmum(): bool
    {
        return $this->role === 'umum';
    }

    /**
     * Check if user is a pimpinan (leader).
     */
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    /**
     * Check if user is a Kepala Bidang (either PSP or TP).
     */
    public function isKabid(): bool
    {
        return in_array($this->role, ['kabid_psp', 'kabid_tp']);
    }

    public function isKabidPsp(): bool
    {
        return $this->role === 'kabid_psp';
    }

    public function isKabidTp(): bool
    {
        return $this->role === 'kabid_tp';
    }

    /**
     * Human-readable label for role.
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin'      => 'Admin Dinas',
            'pimpinan'   => 'Pimpinan / Kepala Dinas',
            'kabid_psp'  => 'Kepala Bidang PSP',
            'kabid_tp'   => 'Kepala Bidang Tanaman Pangan',
            'user'       => 'Kelompok Tani',
            'umum'       => 'Umum',
            default      => ucfirst($this->role),
        };
    }

    /**
     * Check if user account is approved.
     */
    public function isApproved(): bool
    {
        if ($this->isAdmin() || $this->isPimpinan() || $this->isUmum()) {
            return true;
        }

        return $this->farmerProfile && $this->farmerProfile->status === 'approved';
    }

    /**
     * Get the farmer profile associated with the user.
     */
    public function farmerProfile(): HasOne
    {
        return $this->hasOne(FarmerProfile::class);
    }

    /**
     * Get all proposals submitted by the user.
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Proposals assigned to this kabid.
     */
    public function assignedProposals(): HasMany
    {
        return $this->hasMany(Proposal::class, 'kabid_id');
    }

    /**
     * Survey teams created by this kabid.
     */
    public function surveyTeams(): HasMany
    {
        return $this->hasMany(SurveyTeam::class, 'kabid_id');
    }

}
