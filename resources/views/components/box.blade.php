@props(['dataBox' => []])
<div class="col-lg-3 col-6">
    <div class="info-box">
        <span class="info-box-icon {{ $dataBox['background'] }} bg-info elevation-1"><i class="{{ $dataBox['icon'] }}"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">{{ $dataBox['value'] }}</span>
            <span class="info-box-number">
                {{ $dataBox['label'] }}
                <a href="{{ $dataBox['href'] }}">
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </span>
        </div>
    </div>
</div>

