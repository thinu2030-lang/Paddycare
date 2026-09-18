<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'district', 'phone', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Role helper methods
    public function hasRole(string $role): bool {
        return $this->role === $role;
    }

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isOfficer(): bool { return $this->role === 'officer'; }
    public function isFarmer(): bool  { return $this->role === 'farmer'; }

    public function assignRole(string $role): void {
        $this->update(['role' => $role]);
    }

    // Relationships
    public function diagnoses() {
        return $this->hasMany(Diagnosis::class);
    }

    public function farmerAppointments() {
        return $this->hasMany(Appointment::class, 'farmer_id');
    }

    public function officerAppointments() {
        return $this->hasMany(Appointment::class, 'officer_id');
    }

    // Scope — officers list ගන්න
    public function scopeRole($query, string $role) {
        return $query->where('role', $role);
    }
}