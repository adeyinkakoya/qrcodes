<!-- Id Field -->
<div class="col-md-6">
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $qrcode->id !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{!! $qrcode->user_id !!}</p>
</div>

<!-- Website Field -->
<div class="form-group">
    {!! Form::label('website', 'Website:') !!}
    <p>{!! $qrcode->website !!}</p>
</div>

<!-- Company Name Field -->
<div class="form-group">
    {!! Form::label('company_name', 'Company Name:') !!}
    <p>{!! $qrcode->company_name !!}</p>
</div>
<!-- If the user id of the qrcode creator (if  webmaster/merchant is logged in ) is thesame as the logged in user i.e Im logging in OR if the role of the logged in user is either 1,2,3 i.e Admin, Moderarotor or webmaster
@if($qrcode->user_id == Auth::user()->id || Auth::user()->role_id < 3 )




@endif-->



<!-- Product Name Field -->
<div class="form-group">
    {!! Form::label('product_name', 'Product Name:') !!}
    <p>{!! $qrcode->product_name !!}</p>
</div>

<!-- Product Url Field -->
<div class="form-group">
    {!! Form::label('product_url', 'Product Url:') !!}
    <p>{!! $qrcode->product_url !!}</p>
</div>

<!-- Callback Url Field -->
<div class="form-group">
    {!! Form::label('callback_url', 'Callback Url:') !!}
    <p>{!! $qrcode->callback_url !!}</p>
</div>

<!-- Qrcode Path Field -->
<!-- <div class="form-group">
    {!! Form::label('qrcode_path', 'Qrcode Path:') !!}
    <p>{!! $qrcode->qrcode_path !!}</p>
</div> -->



<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{!! $qrcode->amount !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $qrcode->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $qrcode->created_at->format('D, M , Y') !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $qrcode->updated_at->format('D , M , Y') !!}</p>
</div>
</div>


<div class=" col-md-6 pull-right">
<!-- Qrcode image -->
<div class="form-group">
{!! Form::label('qrcode_path', 'QRCode:') !!}
    <p><img src="{{ asset($qrcode->qrcode_path) }}" size="400px"></p>
</div>

</div>
