<div
    style="
    width: 200px;
    padding: 20px;
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin: 20px;
    border: 2px solid {{ $pessoa->gender == 'masculino' ? 'blue' : 'pink' }};
    box-shadow: -2px 2px 17px rgba(115, 115, 115, 0.5);">

    <img src="{{ $pessoa->image }}" alt="Avatar" style="width: 100%; border-radius: 8px;">

    <div style="padding-top: 20px; text-align: left;">
        <h1 style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">{{ $pessoa->name }}</h1>
        <h3 style="font-size: 14px; color: #555; margin-bottom: 10px;">{{ $pessoa->idade }} Anos</h3>
        <p>Nasceu em {{ \Carbon\Carbon::parse($pessoa->birth)->format('d/m/Y') }}</p>

        @if ($pessoa->cidade)
            <p style="color: #2563eb; font-weight: bold; margin-top: 15px; font-size: 14px;">
                📍 {{ $pessoa->cidade }} - {{ $pessoa->uf }}
            </p>
        @endif
    </div>

</div>
