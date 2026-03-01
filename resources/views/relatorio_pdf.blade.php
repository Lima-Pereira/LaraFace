<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Relatório de Clientes</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #2d3748;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            border: 1px solid #eee;
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Relatório Geral de Membros</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome / CPF</th>
                <th>Endereço Completo</th>
                <th>Cidade/UF</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pessoas as $pessoa)
                <tr>
                    <td>
                        <strong>{{ $pessoa->name }}</strong><br>
                        <small>CPF: {{ $pessoa->cpf }}</small>
                    </td>
                    <td>{{ $pessoa->rua }}, {{ $pessoa->numero }} - {{ $pessoa->bairro }}</td>
                    <td>{{ $pessoa->cidade }} - {{ $pessoa->uf }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
