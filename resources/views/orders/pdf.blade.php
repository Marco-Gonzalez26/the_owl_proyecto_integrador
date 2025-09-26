<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pedido #{{ $order['PedidoId'] ?? '0001' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .total {
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Comprobante de Pedido</h1>
        <p>Pedido #{{ $order['PedidoId'] ?? '0001' }}</p>
        <p>Codigo {{ $order['Codigo'] ?? '0001' }}</p>
        <p>Cliente: {{ $order['NombreCliente'] ?? 'N/A' }}</p>
        <p>Correo: {{ $order['CorreoCliente'] ?? 'N/A' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($order['items']) && is_array($order['items']))
                @foreach($order['items'] as $item)
                <tr>
                    <td>{{ $item['name'] ?? 'N/A' }}</td>
                    <td>{{ $item['quantity'] ?? '0' }}</td>
                    <td>${{ number_format($item['price'] ?? 0, 2) }}</td>
                    <td>${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="total">No hay items disponibles</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">${{ number_format($order['total'] ?? 0, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>