<div class="my-2 text-sm tracking-tight space-y-1">
    @php
        $labels = [
            'judul' => 'Judul',
            'approval_status' => 'Status Persetujuan',
            'retention_status' => 'Status Retensi',
            'rejection_note' => 'Catatan Penolakan',
            'nomor_dokumen' => 'Nomor Dokumen',
            'kategori' => 'Kategori',
            'jenis_dokumen' => 'Jenis Dokumen',
            'sifat_surat' => 'Sifat Surat',
        ];

        $statusLabels = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'aktif' => 'Aktif',
            'inaktif' => 'Inaktif',
            'permanen' => 'Permanen',
        ];

        $state = $getState() ?? [];
        $old = $state['old'] ?? [];
        $new = $state['attributes'] ?? [];
        $keys = collect(array_keys($old))->merge(array_keys($new))->unique();

        $format = function ($value, $isNewSide = false) use ($statusLabels) {
            if ($value === null || $value === '') {
                return $isNewSide
                    ? '<span class="italic text-gray-400">(dikosongkan)</span>'
                    : '<span class="italic text-gray-400">(belum ada)</span>';
            }
            if (is_array($value)) {
                return e(json_encode($value));
            }
            return e($statusLabels[$value] ?? $value);
        };
    @endphp

    @if($keys->isEmpty())
        <span class="text-gray-400">-</span>
    @else
        @foreach($keys as $key)
            @php
                $oldValue = $old[$key] ?? null;
                $newValue = $new[$key] ?? null;
                $hasOld = array_key_exists($key, $old);
                $hasNew = array_key_exists($key, $new);
                $label = $labels[$key] ?? Str::headline($key);

                $isNoiseOnCreate = $hasNew && !$hasOld && ($newValue === null || $newValue === '');
                $isNoiseOnDelete = $hasOld && !$hasNew && ($oldValue === null || $oldValue === '');
                $isClearedNote = $key === 'rejection_note' && $hasOld && $hasNew && ($newValue === null || $newValue === '');
                $isFreshNote = $key === 'rejection_note' && $hasNew && $newValue !== null && $newValue !== '' && ($oldValue === null || $oldValue === '');
            @endphp

            @continue($isNoiseOnCreate || $isNoiseOnDelete || $isClearedNote)

            <div class="flex flex-wrap items-center gap-1">
                <span class="inline-block px-2 py-0.5 font-medium text-gray-700 rounded-md dark:text-gray-200 bg-gray-500/10">
                    {{ $label }}
                </span>

                @if($isFreshNote)
                    <span class="text-gray-700 dark:text-gray-200">ditambahkan</span>
                @elseif($hasOld && $hasNew)
                    <span class="text-red-500 line-through">{!! $format($oldValue) !!}</span>
                    <span>&rarr;</span>
                    <span class="text-green-600 dark:text-green-400 font-medium">{!! $format($newValue, true) !!}</span>
                @elseif($hasNew)
                    <span class="text-green-600 dark:text-green-400 font-medium">{!! $format($newValue, true) !!}</span>
                @else
                    <span class="text-red-500 line-through">{!! $format($oldValue) !!}</span>
                @endif
            </div>
        @endforeach
    @endif
</div>
