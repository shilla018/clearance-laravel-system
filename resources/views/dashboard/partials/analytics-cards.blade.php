<div class="row g-3 g-xl-4 mb-4">
    @foreach ([
        ['label' => 'Students Applied', 'value' => $analytics['applied_percentage'].'%', 'icon' => 'bi-person-check'],
        ['label' => 'Completed Clearance', 'value' => $analytics['completed_percentage'].'%', 'icon' => 'bi-check2-circle'],
        ['label' => 'Completed On Time', 'value' => $analytics['on_time_percentage'].'%', 'icon' => 'bi-clock-history'],
        ['label' => 'Open Support Issues', 'value' => $analytics['open_tickets'], 'icon' => 'bi-life-preserver'],
    ] as $card)
        <div class="col-6 col-xxl-3">
            <article class="dashboard-stat-card dashboard-stat-card--blue">
                <div class="dashboard-stat-card__icon"><i class="bi {{ $card['icon'] }}"></i></div>
                <div>
                    <span class="dashboard-stat-card__label">{{ $card['label'] }}</span>
                    <h2 class="dashboard-stat-card__value">{{ $card['value'] }}</h2>
                </div>
            </article>
        </div>
    @endforeach
</div>

<div class="row g-3 g-xl-4 mb-4">
    @foreach ([
        ['label' => 'Applications', 'value' => $analytics['applications']],
        ['label' => 'Pending', 'value' => $analytics['pending']],
        ['label' => 'Approved', 'value' => $analytics['approved']],
        ['label' => 'Declined', 'value' => $analytics['denied']],
    ] as $tile)
        <div class="col-6 col-xl-3">
            <article class="dashboard-summary-tile">
                <div class="dashboard-summary-tile__icon"><i class="bi bi-bar-chart"></i></div>
                <div>
                    <span class="dashboard-summary-tile__label">{{ $tile['label'] }}</span>
                    <div class="dashboard-summary-tile__value">{{ $tile['value'] }}</div>
                </div>
            </article>
        </div>
    @endforeach
</div>
