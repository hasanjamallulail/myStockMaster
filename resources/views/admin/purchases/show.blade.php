@extends('layouts.app')

@section('title', 'Purchases Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">{{__('Purchases')}}</a></li>
        <li class="breadcrumb-item active">{{__('Details')}}</li>
    </ol>
@endsection

@section('content')
    <div class="px-4 mx-auto">
        <div class="row">
            <div class="w-full px-4">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Reference: <strong>{{ $purchase->reference }}</strong>
                        </div>
                        <a target="_blank" class="btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route('purchases.pdf', $purchase->id) }}">
                            <i class="bi bi-printer"></i> Print
                        </a>
                        <a target="_blank" class="btn-info mfe-1 d-print-none" href="{{ route('purchases.pdf', $purchase->id) }}">
                            <i class="bi bi-save"></i> Save
                        </a>
                    </div>
                    <div class="p-4">
                        <div class="row mb-4">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">{{__('Company Info')}}:</h5>
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                                <div>{{__('Email')}}: {{ settings()->company_email }}</div>
                                <div>{{__('Phone')}}: {{ settings()->company_phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">{{__('Supplier Info')}}:</h5>
                                <div><strong>{{ $supplier->name }}</strong></div>
                                <div>{{ $supplier->address }}</div>
                                <div>{{__('Email')}}: {{ $supplier->email }}</div>
                                <div>{{__('Phone')}}: {{ $supplier->phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">{{__('Invoice Info')}}:</h5>
                                <div>{{__('Invoice')}}: <strong>INV/{{ $purchase->reference }}</strong></div>
                                <div>{{__('Date')}}: {{ \Carbon\Carbon::parse($purchase->date)->format('d M, Y') }}</div>
                                <div>
                                    {{__('Status')}}: <strong>{{ $purchase->status }}</strong>
                                </div>
                                <div>
                                    {{__('Payment Status')}}: <strong>{{ $purchase->payment_status }}</strong>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="align-middle">{{__('Product')}}</th>
                                    <th class="align-middle">{{__('Net Unit Price')}}</th>
                                    <th class="align-middle">{{__('Quantity')}}</th>
                                    <th class="align-middle">{{__('Discount')}}</th>
                                    <th class="align-middle">{{__('Tax')}}</th>
                                    <th class="align-middle">{{__('Sub Total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($purchase->purchaseDetails as $item)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $item->name }} <br>
                                            <span class="badge badge-success">
                                                {{ $item->code }}
                                            </span>
                                        </td>

                                        <td class="align-middle">{{ format_currency($item->unit_price) }}</td>

                                        <td class="align-middle">
                                            {{ $item->quantity }}
                                        </td>

                                        <td class="align-middle">
                                            {{ format_currency($item->product_discount_amount) }}
                                        </td>

                                        <td class="align-middle">
                                            {{ format_currency($item->product_tax_amount) }}
                                        </td>

                                        <td class="align-middle">
                                            {{ format_currency($item->sub_total) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0 col-sm-5 ml-md-auto">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="left"><strong>{{__('Discount')}} ({{ $purchase->discount_percentage }}%)</strong></td>
                                        <td class="right">{{ format_currency($purchase->discount_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>{{__('Tax')}} ({{ $purchase->tax_percentage }}%)</strong></td>
                                        <td class="right">{{ format_currency($purchase->tax_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>{{__('Shipping')}})</strong></td>
                                        <td class="right">{{ format_currency($purchase->shipping_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>{{__('Grand Total')}}</strong></td>
                                        <td class="right"><strong>{{ format_currency($purchase->total_amount) }}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
