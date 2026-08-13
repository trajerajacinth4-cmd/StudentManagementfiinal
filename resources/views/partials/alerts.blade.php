@foreach ([
    'success' => ['icon' => 'bi-check-circle-fill',       'border' => '#16a34a'],
    'error'   => ['icon' => 'bi-exclamation-triangle-fill','border' => '#dc2626'],
    'warning' => ['icon' => 'bi-exclamation-circle-fill',  'border' => '#d97706'],
    'info'    => ['icon' => 'bi-info-circle-fill',         'border' => '#0891b2'],
] as $type => $cfg)
    @if(session($type))
        <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} alert-dismissible fade show shadow-sm border-0 mb-3 js-auto-alert"
             role="alert"
             style="border-left: 4px solid {{ $cfg['border'] }} !important; border-radius: .75rem;">
            <i class="bi {{ $cfg['icon'] }} me-2"></i>{{ session($type) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach

<script>
    // Auto-dismiss flash alerts after 5 seconds
    document.querySelectorAll('.js-auto-alert').forEach(function (el) {
        setTimeout(function () {
            var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });
</script>

