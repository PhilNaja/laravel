@extends('layouts.app')
@section('content')
<div class="container col-sm">
    <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
    @component('compronents.buttonback')
    @endcomponent
    </div>

<div class="row">
  <div class="col-sm-8">
  <div class="card">
  <div class="card-header">
    <div class="text-center">
      ใบเสร็จชำระเงิน
    </div>
    <div class="container col-sm">
  <div class='container-sm mt-1 mb-3 d-flex justify-content-end align-items-end'>
  No. {{$house[0]->id}}
    
    </div>
    <div class='container-sm mt-1 mb-3 d-flex justify-content-start align-items-start'>
    บ้านเลขที่ {{$house[0]->housenumber}}
    <br>
    ชื่อ {{$house[0]->owner}}
    <br>
    รอบบิล {{$house[0]->billingcycle}}
    </div>
    </div>
  </div>
  <div class="card-body">
    <table class="table">
  <thead >
    <tr >
      <th scope="col"class="text-center">รายการ</th>
      <th scope="col">จำนวน</th>
      <th scope="col">ราคา/หน่วย</th>
      <th scope="col">สุทธิ</th>
    </tr>
  </thead>
  <tbody>
    @if($metre!='[]')
    @foreach($metre as $metre)
        <tr>
      <td class=' d-flex justify-content-start align-items-start ms-2'>{{$metre->name}} Befor{{$metre->pre_unit}} - After{{$metre->unit}}</td>
      <td>{{$metre->unit-$metre->pre_unit}}</td>
      <td>{{$metre->price_unit}}</td>
      <td>{{$metre->amount}}</td>
    </tr>
    @endforeach
    @endif
    @if($fee!='[]')
    @foreach($fee as $fee)
    <tr>
      <td class=' d-flex justify-content-start align-items-start ms-2'>ค่าส่วนกลาง ประเภท {{$fee->name}}</td>
      <td>1</td>
      <td>{{$fee->price_unit}}</td>
      <td>{{$fee->price_unit}}</td>
    </tr>
    @endforeach
    @endif
    @if($fine!='[]')
    @foreach($fine as $fine)
    <tr>
      <td class=' d-flex justify-content-start align-items-start ms-2'>ค่าปรับ</td>
      <td>1</td>
      <td>{{$fine->amount}}</td>
      <td>{{$fine->amount}}</td>
    </tr>
    @endforeach
    @endif
    <tr>
      <td colspan="3">Total</td>
      <td>{{$house[0]->amount}}</td>
    </tr>
  </tbody>
</table>
  </div>
</div>
  </div>
  <div class="col-sm-4">
  <div class="card">
  <h5 class="card-header">หนี้ที่ยังไม่ได้ชำระ</h5>
  <div class="card-body">
  <table class="table">
  <thead >
    <tr >
      <th scope="col"class="text-center">รายการ</th>
      <th scope="col">สุทธิ</th>
    </tr>
  </thead>
  <tbody>
  @if($bill!='[]')
    @foreach($bill as $bill)
    <tr>
      <td class=' d-flex justify-content-start align-items-start ms-2'>หนี้จาก บิล {{$bill->billingcycle}} </td>
      <td>{{$bill->amount}}</td>
    </tr>
    @endforeach
    @endif
    @if($debt!='[]')
    @foreach($debt as $debt)
    <tr>
      <td class=' d-flex justify-content-start align-items-start ms-2'>{{$debt->note}}</td>
      <td>{{$debt->total_balance-$debt->balance}}</td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
  </div>
</div>
  </div>
</div>


</div>

@endsection

