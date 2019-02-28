<table class="table table-responsive" id="transactions-table">
    <thead>
        <tr>
        <th>Buyer name</th>
        <th>Qrcode Owner Name</th>
        <th>Product Name</th>
        <th>Payment Method</th>
        <th>Message</th>
        <th>Amount</th>
        <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>
            <a href=" {{ route('users.show',$transaction->user['id'] ) }}">
            {!! $transaction->user['name'] !!}
            </a>
            </td>
            <td>
            <a href=" {{ route('users.show',$transaction->qrcode['user_id'] ) }}">
            {!! $transaction->qrcode_owner['name'] !!}
            </a>
            </td>
            <td>{!! $transaction->qrcode['product_name'] !!}</td>
            <td>{!! $transaction->payment_method !!}</td>
            <td>{!! $transaction->message !!}</td>
            <td>{!! $transaction->amount !!}</td>
            <td>{!! $transaction->status !!}</td>
            <td>
                {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('transactions.show', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('transactions.edit', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
