@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-8 p-8">
            <div>
                @if($truck->image)
                    <img src="{{ Storage::url($truck->image) }}" alt="{{ $truck->brand }}" class="w-full h-auto rounded-xl">
                @endif
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $truck->brand }} {{ $truck->model }}</h1>
                <p class="text-gray-500 text-sm">{{ $truck->year }} год</p>
                <div class="text-4xl font-bold text-blue-600 mt-4">{{ $truck->formatted_price }}</div>

                <div class="mt-6 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Двигатель:</span>
                        <span>{{ $truck->engine ?? 'Не указан' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Трансмиссия:</span>
                        <span>{{ $truck->transmission ?? 'Не указана' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Пробег:</span>
                        <span>{{ $truck->mileage ? number_format($truck->mileage, 0, '', ' ') . ' км' : 'Не указан' }}</span>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <h3 class="font-bold">Описание</h3>
                    <p class="text-gray-600 mt-2">{{ $truck->description }}</p>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="tel:89023143540" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition flex-1 text-center">
                        📞 Позвонить
                    </a>
                    <a href="mailto:guga-2005@mail.ru" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition flex-1 text-center">
                        ✉️ Написать
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
