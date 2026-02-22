<div
    style="
    width: 200px;
    padding: 20px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin: 20px;
    border: 2px solid {{$pessoa->gender== 'masculino' ? 'blue' : 'pink'}};
    box-shadow: -2px 2px 17px rgba(115, 115, 115, 0.5);">

    <img src="{{ $pessoa->image }}" alt="Avatar">

    <div style="padding: 20px;">
        <h1>{{ $pessoa->name }}</h1>
        <h3>{{ $pessoa->age }} Anos</h3>
        <p> Nasceu em {{ $pessoa->birth }}</p>
    </div>

    <form action="{{ route('pessoa.deletar', $pessoa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
        @csrf
        @method('DELETE') <button type="submit" style="color: red; background: none; border: none; cursor: pointer; font-size: 12px; padding: 0;">
            Excluir 
            
        </button>
    </form>

</div>
