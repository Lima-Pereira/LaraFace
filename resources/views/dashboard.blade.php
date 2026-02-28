<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel') }}
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
                                <div>
                                    <strong>{{ $pessoa->name }}</strong>
                                    <span class="text-sm text-gray-500">({{ $pessoa->idade }} anos)</span>
                                </div>

                                <div class="flex space-x-3">
                                    <a href="{{ route('pessoa.edit', $pessoa->id) }}"
                                        class="text-blue-600 hover:text-blue-800">Editar</a>

                                    <form action="{{ route('pessoa.deletar', $pessoa->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
