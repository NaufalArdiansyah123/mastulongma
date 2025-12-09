<x-app-layout>
	<x-slot name="title">Riwayat Bantuan</x-slot>

	<div class="min-h-screen bg-gray-50">
		<!-- Header Section -->
		<div class="px-5 pt-6 pb-6 bg-gradient-to-br from-primary-400 via-primary-500 to-primary-600 rounded-b-3xl">
			<div class="flex items-center justify-between">
				<a href="{{ route('customer.dashboard') }}" class="p-2 -ml-2 hover:bg-white/20 rounded-xl transition-all duration-300 flex-shrink-0 text-white">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
					</svg>
				</a>

				<div class="text-center flex-1 px-2">
					<h1 class="text-lg font-bold text-white">Riwayat Bantuan</h1>
					<p class="text-sm text-white/90 mt-0.5">Bantuan yang telah selesai</p>
				</div>

				<div class="w-8"></div>
			</div>
		</div>

		<!-- Main Content -->
		<div class="px-5 pt-6 pb-24">
			<div class="max-w-4xl mx-auto">
				<div class="bg-white rounded-t-[32px] -mt-10 p-6 shadow-lg">
					{{-- Stats --}}
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
						<div class="text-center">
							<div class="text-xs text-gray-500">Total Selesai</div>
							<div class="text-xl font-bold mt-1">{{ $completedHelps->total() ?? 0 }}</div>
						</div>

						<div class="text-center">
							<div class="text-xs text-gray-500">Total Nilai</div>
							<div class="text-xl font-bold mt-1">Rp {{ number_format($completedHelps->sum('amount') ?? 0, 0, ',', '.') }}</div>
						</div>

						<div class="text-center">
							<div class="text-xs text-gray-500">Mitra Bantu</div>
							<div class="text-xl font-bold mt-1">{{ $completedHelps->unique('mitra_id')->count() ?? 0 }}</div>
						</div>
					</div>

					{{-- List --}}
					@if(isset($completedHelps) && $completedHelps->isEmpty())
						<div class="bg-white p-6 rounded-lg shadow text-center">
							<p class="text-gray-600 mb-4">Belum ada bantuan yang selesai.</p>
							<a href="{{ route('customer.helps.create') }}" class="inline-block bg-primary-500 text-white px-4 py-2 rounded-lg font-semibold">Buat Bantuan Baru</a>
						</div>
					@elseif(isset($completedHelps))
						<ul class="space-y-3">
							@foreach($completedHelps as $help)
								<li x-data="{ open: false }" class="bg-white rounded-lg shadow overflow-hidden">
									<div class="p-4 flex items-center justify-between gap-4">
										<div class="flex items-center gap-4 min-w-0">
											<div class="w-14 h-14 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-50">
												@if($help->photo)
													<img src="{{ asset('storage/' . $help->photo) }}" alt="foto" class="w-full h-full object-cover">
												@else
													<div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-600">✓</div>
												@endif
											</div>

											<div class="min-w-0">
												<div class="font-semibold text-gray-900 truncate">{{ $help->title ?? 'Permintaan Bantuan' }}</div>
												<div class="text-xs text-gray-500 truncate">{{ optional($help->city)->name }} • {{ optional($help->updated_at)->format('d M Y') }}</div>
											</div>
										</div>

										<div class="flex items-center gap-3">
											<div class="text-sm font-semibold">Rp {{ number_format($help->amount ?? 0, 0, ',', '.') }}</div>

											<button @click="open = !open" class="flex items-center gap-2 text-sm text-primary-600 font-semibold px-3 py-1.5 border border-primary-100 rounded-full hover:bg-primary-50 transition">
												<svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
												</svg>
												<span x-text="open ? 'Tutup' : 'Detail'"></span>
											</button>
										</div>
									</div>

									<div x-show="open" x-cloak x-transition class="p-4 bg-gray-50 border-t border-gray-100 text-sm text-gray-700">
										<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
											<div class="md:col-span-1">
												@if($help->photo)
													<img src="{{ asset('storage/' . $help->photo) }}" alt="foto bantuan" class="w-full h-28 object-cover rounded-lg shadow-sm">
												@else
													<div class="w-full h-28 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
												@endif
											</div>

											<div class="md:col-span-3">
												<div class="flex items-start justify-between">
													<div class="space-y-1">
														@if($help->description)
															<div><strong class="text-gray-800">Deskripsi</strong></div>
															<div class="text-gray-700 leading-relaxed">{{ $help->description }}</div>
														@endif
													</div>

													<div class="ml-4 text-right">
														<span class="inline-flex items-center px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">✓ Selesai</span>
													</div>
												</div>

												<div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
													<div>
														<div class="text-xs text-gray-500">Alamat / Kota</div>
														<div class="text-gray-800">{{ $help->full_address ?? optional($help->city)->name ?? '-' }}</div>
													</div>

													@if($help->mitra)
														<div>
															<div class="text-xs text-gray-500">Mitra</div>
															<div class="text-gray-800">{{ $help->mitra->name }}</div>
															@if($help->mitra->phone)
																<div class="text-xs text-primary-600"><a href="tel:{{ $help->mitra->phone }}">{{ $help->mitra->phone }}</a></div>
															@endif
														</div>
													@endif
												</div>

												<div class="mt-3 text-xs text-gray-500">Waktu: <span class="text-gray-700">{{ optional($help->updated_at)->format('d M Y H:i') }}</span></div>

												{{-- Rating form for customer -> mitra (shown when not yet rated) --}}
												@if($help->mitra && !\App\Models\Rating::hasRated($help->id, auth()->id(), 'customer_to_mitra'))
													<div class="mt-3">
														@livewire('customer.rate-mitra', ['helpId' => $help->id])
													</div>
												@endif
											</div>
										</div>
									</div>
								</li>
							@endforeach
						</ul>

						<div class="mt-4">
							{{ $completedHelps->links() }}
						</div>
					@else
						<div class="text-gray-600">Data riwayat belum tersedia.</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
