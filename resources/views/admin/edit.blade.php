<!DOCTYPE html>
<html>
<head>
    <title>Редактировать грузовик</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Редактировать грузовик</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.update', $truck) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Марка *</label>
                    <input type="text" name="brand" value="{{ old('brand', $truck->brand) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Модель *</label>
                    <input type="text" name="model" value="{{ old('model', $truck->model) }}" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Год выпуска *</label>
                    <input type="number" name="year" value="{{ old('year', $truck->year) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Цена (₽) *</label>
                    <input type="number" name="price" value="{{ old('price', $truck->price) }}" class="w-full border rounded px-3 py-2" required step="0.01">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Описание *</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description', $truck->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Двигатель</label>
                    <input type="text" name="engine" value="{{ old('engine', $truck->engine) }}" class="w-full border rounded px-3 py-2" placeholder="Например: 12.5л, 450 л.с.">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Трансмиссия</label>
                    <input type="text" name="transmission" value="{{ old('transmission', $truck->transmission) }}" class="w-full border rounded px-3 py-2" placeholder="Например: Механика, 6 ступеней">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Пробег (км)</label>
                    <input type="number" name="mileage" value="{{ old('mileage', $truck->mileage) }}" class="w-full border rounded px-3 py-2" placeholder="Например: 150000">
                </div>

                <div class="mb-4 flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_available" value="1" {{ $truck->is_available ? 'checked' : '' }}>
                        <span class="ml-2">В наличии</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Фото грузовика</label>

                @if($truck->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($truck->image) }}" alt="Текущее фото" class="h-32 w-auto object-cover rounded border">
                        <p class="text-xs text-gray-500">Текущее фото</p>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Максимум 2MB. Поддерживаются: JPG, PNG, GIF</p>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600">Обновить</button>
                <a href="{{ route('admin.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Отмена</a>
            </div>
        </form>
    </div>
</body>
</html>
