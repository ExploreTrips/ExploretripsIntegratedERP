@php
    $user = json_decode($users->details);
@endphp

<div class="modal-body">
    <div class="row g-4">
        {{-- Reusable card for each field --}}
        @php
            $fields = [
                ['Status', $user->status ?? '', 'fas fa-toggle-on'],
                ['Country', $user->country ?? '', 'fas fa-flag'],
                ['Country Code', $user->countryCode ?? '', 'fas fa-globe'],
                ['Region', $user->region ?? '', 'fas fa-map'],
                ['Region Name', $user->regionName ?? '', 'fas fa-map-marker-alt'],
                ['City', $user->city ?? '', 'fas fa-city'],
                ['Zip', $user->zip ?? '', 'fas fa-mail-bulk'],
                ['Latitude', $user->lat ?? '', 'fas fa-location-arrow'],
                ['Longitude', $user->lon ?? '', 'fas fa-location-arrow'],
                ['Timezone', $user->timezone ?? '', 'fas fa-clock'],
                ['ISP', $user->isp ?? '', 'fas fa-wifi'],
                ['Org', $user->org ?? '', 'fas fa-building'],
                ['AS', $user->as ?? '', 'fas fa-network-wired'],
                ['Query', $user->query ?? '', 'fas fa-search-location'],
                ['Browser Name', $user->browser_name ?? '', 'fas fa-browser'],
                ['OS Name', $user->os_name ?? '', 'fas fa-desktop'],
                ['Browser Language', $user->browser_language ?? '', 'fas fa-language'],
                ['Device Type', $user->device_type ?? '', 'fas fa-mobile-alt'],
                ['Referrer Host', $user->referrer_host ?? '', 'fas fa-server'],
                ['Referrer Path', $user->referrer_path ?? '', 'fas fa-route'],
            ];
        @endphp

        @foreach ($fields as [$label, $value, $icon])
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-2 d-flex align-items-start gap-2">
                        <i class="{{ $icon }} text-primary mt-1" style="min-width: 20px;"></i>
                        <div>
                            <div class="small text-muted fw-bold">{{ __($label) }}</div>
                            <div class="fw-semibold text-dark">{{ $value ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
