@extends('layouts.app')

@section('content')
    <section class="content-header">
    <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <h1 class='pull-left'>
            Account : {!! $account->id !!}
            <small>
            @if($account->applied_for_payout ==1)
            Payment processing and pending
            @endif
            </small>
        </h1>

        <div class='pull-right'>
        <!-- Show only if the Authenticated/logged in user is same as the Account User and no pending payment payout-->
        @if(Auth::user()->id == $account->user_id && $account->applied_for_payout !=1)
        {!! Form::open(['route' => ['accounts.payout'], 'method' => 'post','class'=>'pull-left']) !!}
                <div class='btn-group'>
                    
                    <input name='accountID' type='hidden' value='{{ $account->id }}'>
                    {!! Form::button('<i class="glyphicon glyphicon-usd"></i> Apply for Payout', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs', 'onclick' => "return confirm('Confirm request for payout?')"]) !!}
                </div>
                {!! Form::close() !!}

        @endif

        <!-- Show only if the logged in user is Admin or Moderator and Paid is 0 -->
        @if( Auth::user()->role_id < 3 && $account->paid == 0 )
                {!! Form::open(['route' => ['accounts.mark_as_paid'], 'method' => 'post','class'=>'pull-right','style'=>'margin-left:10px']) !!}
                <div class='btn-group'>
                    
                <input name='accountID' type='hidden' value='{{ $account->id }}'>
                    {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Mark as paid', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs', 'onclick' => "return confirm('Confirm payment?')"]) !!}
                </div>
                {!! Form::close() !!}
        @endif
        
        </div>
    </section>
    
    <div class="content">
    <div class='clearfix'></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                    <a href="{!! route('accounts.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
