<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5eedc; color: #333; padding: 30px 16px; }
        .container { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.10); }
        .header { background: #ff8800; padding: 32px; text-align: center; }
        .header h1 { color: #fff; font-size: 24px; letter-spacing: 0.02em; }
        .header p  { color: rgba(255,255,255,0.85); margin-top: 6px; font-size: 13px; }
        .body { padding: 24px 28px; }
        .greeting { font-size: 15px; color: #555; margin-bottom: 18px; }
        .greeting strong { color: #222; }
        .ingredients-table { width: 100%; border-collapse: separate; border-spacing: 6px; }
        .ingredient-cell { width: 50%; }
        .ingredient-chip {
            display: block;
            background: #fff4ec;
            border: 1px solid #ffd4b0;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            color: #b34700;
            word-break: break-word;
        }
        .footer { padding: 16px 28px; text-align: center; font-size: 12px; color: #bbb; border-top: 1px solid #f0e8df; }
        .footer a { color: #ff8800; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <h1>Lista de la compra</h1>
            <p>RecipEZ &ndash; Tu recetario online</p>
        </div>

        <div class="body">
            <p class="greeting">Hola, <strong>{{ $user->name }}</strong>. Aquí tienes tu lista de la compra:</p>

            {{-- Tabla de 2 columnas, compatible con todos los clientes de correo --}}
            <table class="ingredients-table" role="presentation">
                @foreach ($items->chunk(2) as $row)
                <tr>
                    @foreach ($row as $item)
                    <td class="ingredient-cell">
                        <span class="ingredient-chip">{{ $item->ingredient->name }}</span>
                    </td>
                    @endforeach
                    {{-- Si la fila tiene solo 1 ítem, rellenamos la celda vacía --}}
                    @if ($row->count() === 1)
                    <td class="ingredient-cell"></td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>

        <div class="footer">
            Enviado desde <a href="{{ config('app.url') }}">RecipEZ</a>
        </div>

    </div>
</body>
</html>
