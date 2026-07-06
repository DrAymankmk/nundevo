@php(extract(\App\Support\Cms\AboutUsSectionPresenter::data($section)))

<div class="about-area overflow-hidden" style="margin: 100px 20px;" id="about-sec">
	<div class="container">
		<div class="row gy-4">
			<div class="col-xxl-8 mb-30 mb-xl-0">
				<div class="title-area">
					<span class="sub-title">{{ $sub }}</span>
					<h2 class="sec-title text-anime-style-3">{!! $title !!}</h2>
				</div>
				<div class="img-box1">
					<div class="about-wrapper">
						<div>
							<div class="cms-about-desc{{ $descHasListItems ? ' checklist' : '' }}">
								{!! $desc !!}
							</div>
							@if($aboutButtons->isNotEmpty())
							<div class="btn-group mt-40 wow fadeInUp" data-wow-delay=".4s">
								@foreach($aboutButtons as $btn)
								<a href="{{ $btn['href'] }}"
									class="{{ $btn['btnClass'] }}"
									@if(($btn['target'] ?? '_self') === '_blank') target="_blank" @endif
									@if(! empty($btn['rel'])) rel="{{ $btn['rel'] }}" @endif>
									{{ $btn['label'] }}
									@if(! empty($btn['icon']))
									<i class="{{ $btn['icon'] }}"></i>
									@endif
								</a>
								@endforeach
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-4">
				<div class="img-box2">
					<div class="img-box-wrapp">
						<div class="img1 reveal">
							<img src="{{ $sideImg1 }}" alt="{{ $aboutAlt }}" style="width: 100%; height: 300px; object-fit: cover;">
						</div>
						<div class="img2 reveal">
							<img src="{{ $sideImg2 }}" alt="{{ $aboutAlt }}" style="width: 100%; height: 300px; object-fit: cover;">
						</div>
					</div>
					<div class="about-wrapp">
						<div class="discount-wrapp">
							<div class="logo">
								<img src="{{ asset('frontend/assets/img/shape/logo.svg') }}" alt="{{ __('main.app_name') }}">
							</div>
							<div class="discount-tag">
								<span class="discount-anime">{{ $discountLabel }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
