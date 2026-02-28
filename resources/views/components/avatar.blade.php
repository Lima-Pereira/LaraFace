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

    <img src="{{ $pessoa->image }}" alt="Avatar">

    <div style="padding: 20px;">
        <h1>{{ $pessoa->name }}</h1>
        <h3>{{ $pessoa->age }} Anos</h3>
        <p> Nasceu em {{ $pessoa->birth }}</p>
    </div>



</div>
