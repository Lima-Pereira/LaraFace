<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Meus Clientes</h3>

                    <ul class="space-y-4">
                        @foreach ($pessoas as $pessoa)
                            <li class="flex justify-between items-center border-b pb-2">

                                <div class="flex justify-between items-center border-b py-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 uppercase">
                                            {{ $pessoa->name }} <span
                                                class="text-sm text-gray-500 font-normal">({{ $pessoa->idade }}
                                                anos)</span>
                                        </h4>
                                        <div class="text-sm text-gray-600 mt-1">
                                            <span class="mr-4"><strong>CPF:</strong> {{ $pessoa->cpf }}</span>
                                            <span>📍 {{ $pessoa->cidade }} - {{ $pessoa->uf }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 italic">
                                            🏠 {{ $pessoa->rua }}, {{ $pessoa->numero }} - {{ $pessoa->bairro }}
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <a href="{{ route('pessoa.edit', $pessoa->id) }}"
                                            class="text-blue-600 hover:underline">Editar</a>
                                        <form action="{{ route('pessoa.destroy', $pessoa->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                        </form>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
