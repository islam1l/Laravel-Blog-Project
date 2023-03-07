<x-form.field>
    <button type="submit"

        {{$attributes(['class' => 'bg-blue-500 font-semibold hover:bg-blue-600 px-10 py-2
                                    rounded-2xl text-white text-xs uppercase'])}}
    >
        {{ $slot }}
    </button>
</x-form.field>

