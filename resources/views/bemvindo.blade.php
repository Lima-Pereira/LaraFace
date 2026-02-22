<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Portfólio - Gerenciador de Pessoas</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .btn-cadastro { background-color: #2d3748; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: 0.3s; }
        .btn-cadastro:hover { background-color: #4a5568; }
        
        /* Dashboard Stats */
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); flex: 1; text-align: center; }
        .stat-card h3 { margin: 0; color: #718096; font-size: 14px; text-transform: uppercase; }
        .stat-card p { margin: 10px 0 0; font-size: 24px; font-weight: bold; color: #2d3748; }

        /* Alert Success */
        .alert-success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb; }

        .grid-container { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
            gap: 20px; 
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Minha Equipe</h1>
        <a href="{{ route('pessoa.create') }}" class="btn-cadastro">+ Novo Cadastro</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="stats-container">
        <div class="stat-card">
            <h3>Total de Pessoas</h3>
            <p>{{ $totalPessoas }}</p>
        </div>
        <div class="stat-card">
            <h3>Média de Idade</h3>
            <p>{{ number_format($mediaIdade, 1) }} anos</p>
        </div>
    </div>

    <div class="grid-container">
        @foreach ($pessoas as $p)
            <x-avatar :pessoa="$p" />
        @endforeach
    </div>

</body>
</html>