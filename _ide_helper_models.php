<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $judul
 * @property string|null $nomor_dokumen
 * @property string $tanggal_surat
 * @property string $jenis_dokumen
 * @property string $sifat_surat
 * @property string $kategori
 * @property string $opd
 * @property string $tahun
 * @property string $file
 * @property int|null $file_size
 * @property string|null $file_type
 * @property string|null $deskripsi
 * @property int $user_id
 * @property int|null $retention_years
 * @property string|null $final_action
 * @property \Illuminate\Support\Carbon|null $retention_end_date
 * @property string $retention_status
 * @property string $approval_status
 * @property string|null $rejection_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User $user
 * @method static Builder<static>|Archive approved()
 * @method static Builder<static>|Archive forCurrentUser()
 * @method static Builder<static>|Archive newModelQuery()
 * @method static Builder<static>|Archive newQuery()
 * @method static Builder<static>|Archive onlyTrashed()
 * @method static Builder<static>|Archive query()
 * @method static Builder<static>|Archive whereApprovalStatus($value)
 * @method static Builder<static>|Archive whereCreatedAt($value)
 * @method static Builder<static>|Archive whereDeletedAt($value)
 * @method static Builder<static>|Archive whereDeskripsi($value)
 * @method static Builder<static>|Archive whereFile($value)
 * @method static Builder<static>|Archive whereFileSize($value)
 * @method static Builder<static>|Archive whereFileType($value)
 * @method static Builder<static>|Archive whereFinalAction($value)
 * @method static Builder<static>|Archive whereId($value)
 * @method static Builder<static>|Archive whereJenisDokumen($value)
 * @method static Builder<static>|Archive whereJudul($value)
 * @method static Builder<static>|Archive whereKategori($value)
 * @method static Builder<static>|Archive whereNomorDokumen($value)
 * @method static Builder<static>|Archive whereOpd($value)
 * @method static Builder<static>|Archive whereRejectionNote($value)
 * @method static Builder<static>|Archive whereRetentionEndDate($value)
 * @method static Builder<static>|Archive whereRetentionStatus($value)
 * @method static Builder<static>|Archive whereRetentionYears($value)
 * @method static Builder<static>|Archive whereSifatSurat($value)
 * @method static Builder<static>|Archive whereTahun($value)
 * @method static Builder<static>|Archive whereTanggalSurat($value)
 * @method static Builder<static>|Archive whereUpdatedAt($value)
 * @method static Builder<static>|Archive whereUserId($value)
 * @method static Builder<static>|Archive withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Archive withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperArchive {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kategori
 * @property string $jenis_dokumen
 * @property int|null $retention_years
 * @property string $final_action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereFinalAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereJenisDokumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereRetentionYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RetentionRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperRetentionRule {}
}

namespace App\Models{
/**
 * @method bool hasRole(string|array $roles)
 * @method bool hasAnyRole(string|array $roles)
 * @method bool hasAllRoles(string|array $roles)
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $role
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

