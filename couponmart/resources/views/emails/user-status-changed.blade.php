<p>Hello {{ $profile->first_name }},</p>

@if($isBlacklisting)
    <p>Your account has been <strong>blacklisted</strong>.</p>
    <p><strong>Reason:</strong> {{ $reason ?? 'No reason provided.' }}</p>
@else
    <p>Your account has been <strong>activated</strong> again.</p>
@endif

<p>If you believe this was a mistake, please contact support.</p>
