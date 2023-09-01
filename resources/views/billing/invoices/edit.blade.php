@extends('layouts.master') @section('title') billing @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Dashboard @endslot @slot('title') Finance @endslot @endcomponent --}}
<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0 font-size-18">Edit Invoice </h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">Invoices</a></li>
               <li class="breadcrumb-item active"><a>Edit invoice</a></li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- end page title -->
<div class="row justify-content-center">
   <div class="col-xxl-9">
      <div class="card">
         <form action="{{ route('invoice.update',[$invoice->id]) }}" class="needs-validation" novalidate id="invoice_form" method="POST">
            @csrf
            @method('put')
            <div class="card-body p-4">
               <div class="row g-3">
                  <div class="col-lg-3 col-sm-6">
                     <label for="invoicenoInput">Invoice No</label>
                     <input type="text" name="invoice_number" class="form-control bg-light border-0 {{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" value="{{ old('invoice_number') ? old('invoice_number'): $invoice->invoice_number }}" placeholder="Invoice No" readonly/>
                  </div>
                  <!--end col-->
                  <div class="col-lg-3 col-sm-6">
                     <div>
                        <label for="date-field">Due date</label>
                        <input type="text" name="due_date" class="form-control bg-light border-0 {{ $errors->has('due_date') ? ' is-invalid' : '' }}" value="{{ old('due_date') ? old('due_date') : $invoice->due_date }}" data-provider="flatpickr" data-time="true" placeholder="Select Date-time" required >
                        @error('due_date')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <!--end col-->
                  <div class="col-lg-3 col-sm-6">
                     <label for="choices-payment-status">Payment Status</label>
                     <div class="input-light">
                        <select name="status" class="form-control bg-light border-0 {{ $errors->has('status') ? ' is-invalid' : '' }}" id="choices-payment-status" required>
                           <option class="text-muted placeholder" value="" disabled>Select status</option>
                           <option value="unpaid" {{ old('status', $invoice->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                           <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                           <option value="canceled" {{ old('status', $invoice->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <!--end col-->
                  <div class="col-lg-3 col-sm-6">
                     <div>
                        <label for="totalamountInput">Total Amount</label>
                        <input type="text" name="amount" class="form-control bg-light border-0 {{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') ? old('amount') : $invoice->amount }}" id="totalamountInput" placeholder="Ksh 0.00" readonly />
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <!--end col-->
               </div>
               <!--end row-->
            </div>
            <div class="card-body p-4">
               <div class="table-responsive">
                  <table class="invoice-table table table-borderless table-nowrap mb-0">
                     <thead class="align-middle">
                        <tr class="table-active">
                           <th scope="col" style="width: 50px;">#</th>
                           <th scope="col">
                              Product Details
                           </th>
                           <th scope="col" style="width: 120px;">
                              <div class="d-flex currency-select input-light align-items-center">
                                 Rate  
                                 {{-- 
                                 <select class="form-selectborder-0 bg-light" data-choices data-choices-search-false id="choices-payment-currency" onchange="otherPayment()">
                                    <option value="$">($)</option>
                                    <option value="£">(£)</option>
                                    <option value="₹">(₹)</option>
                                    <option value="€">(€)</option>
                                 </select>
                              </div>
                              --}}
                           </th>
                           <th scope="col" style="width: 120px;">Quantity</th>
                           <th scope="col" class="text-end" style="width: 150px;">Amount</th>
                           <th scope="col" class="text-end" style="width: 105px;"></th>
                        </tr>
                     </thead>
                     <tbody id="newlink">
                        @if(old('products'))
                        @foreach(old('products') as $key => $product)
                        <tr class="product" id="{{ $key }}">
                           <th scope="row" class="product-id">{{ $key }}</th>
                           <td class="text-start">
                              <div class="mb-2">
                                 <input type="text" name="products[{{ $key }}][name]" class="form-control bg-light border-0 @error('products.' . $key . '.name') is-invalid @enderror" placeholder="Product Name" value="{{ $product['name'] ?? '' }}" required />
                                 @if($errors->has('products.' . $key . '.name'))
                                 <div class="invalid-feedback">
                                    {{ $errors->first('products.' . $key . '.name') }}
                                 </div>
                                 @endif
                              </div>
                              <textarea name="products[{{ $key }}][details]" class="form-control bg-light border-0" rows="2" placeholder="Product Details">{{ $product['details'] ?? '' }}</textarea>
                           </td>
                           <td>
                              <input type="number" name="products[{{ $key }}][rate]" class="form-control product-price bg-light border-0 @error('products.' . $key . '.rate') is-invalid @enderror" step="0.01" placeholder="0.00" value="{{ $product['rate'] ?? '' }}" required  />
                              @if($errors->has('products.' . $key . '.rate'))
                              <div class="invalid-feedback">
                                 {{ $errors->first('products.' . $key . '.rate') }}
                              </div>
                              @endif
                           </td>
                           <td>
                              <div class="input-step">
                                 <button type="button" class='minus'>–</button>
                                 <input type="number" name="products[{{ $key }}][quantity]" class="product-quantity @error('products.' . $key . '.quantity') is-invalid @enderror" value="{{ $product['quantity'] ?? '0' }}" readonly>
                                 <button type="button" class='plus'>+</button>
                                 @if($errors->has('products.' . $key . '.quantity'))
                                 <div class="invalid-feedback">
                                    {{ $errors->first('products.' . $key . '.quantity') }}
                                 </div>
                                 @endif
                              </div>
                           </td>
                           <td class="text-end">
                              <div>
                                 <input type="text" name="products[{{ $key }}][price]" class="form-control bg-light border-0 product-line-price" placeholder="Ksh 0.00" value="{{ $product['price'] ?? '' }}" readonly />
                              </div>
                           </td>
                           <td class="product-removal">
                              <a href="javascript:void(0)" class="btn btn-success">Delete</a>
                           </td>
                        </tr>
                        @endforeach
                        @elseif($invoice->invoice_items)
                        @foreach($invoice->invoice_items as $key => $item)
                        <tr class="product" id="{{ $key + 1 }}">
                           <input type="hidden" name="products[{{ $key }}][id]" value="{{ $item->id }}" />
                           <th scope="row" class="product-id">{{ $key + 1 }}</th>
                           <td class="text-start">
                              <div class="mb-2">
                                 <input type="text" name="products[{{ $key }}][name]" class="form-control bg-light border-0" placeholder="Product Name" value="{{ $item->name }}" required />
                                 @if($errors->has('products.' . $key . '.name'))
                                 <div class="invalid-feedback">
                                    {{ $errors->first('products.' . $key . '.name') }}
                                 </div>
                                 @endif
                              </div>
                              <textarea name="products[{{ $key }}][details]" class="form-control bg-light border-0" rows="2" placeholder="Product Details">{{ $item->details }}</textarea>
                           </td>
                           <td>
                              <input type="number" name="products[{{ $key }}][rate]" class="form-control product-price bg-light border-0" step="0.01" placeholder="0.00" value="{{ $item->rate }}" required  />
                              @if($errors->has('products.' . $key . '.rate'))
                              <div class="invalid-feedback">
                                 {{ $errors->first('products.' . $key . '.rate') }}
                              </div>
                              @endif
                           </td>
                           <td>
                              <div class="input-step">
                                 <button type="button" class='minus'>–</button>
                                 <input type="number" name="products[{{ $key }}][quantity]" class="product-quantity" value="{{ $item->quantity }}" readonly>
                                 <button type="button" class='plus'>+</button>
                                 @if($errors->has('products.' . $key . '.quantity'))
                                 <div class="invalid-feedback">
                                    {{ $errors->first('products.' . $key . '.quantity') }}
                                 </div>
                                 @endif
                              </div>
                           </td>
                           <td class="text-end">
                              <div>
                                 <input type="text" name="products[{{ $key }}][price]" class="form-control bg-light border-0 product-line-price" placeholder="Ksh 0.00" value="{{ $item->price }}" readonly />
                              </div>
                           </td>
                           <td class="product-removal">
                              <a href="javascript:void(0)" class="btn btn-success">Delete</a>
                           </td>
                        </tr>
                        @endforeach
                        @endif
                     </tbody>
                     <tr id="newForm" style="display: none;"></tr>
                     <tr>
                        <td colspan="9">
                           <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                        </td>
                     </tr>
                     <tr class="border-top border-top-dashed mt-2">
                        <td colspan="3"></td>
                        <td colspan="2" class="p-0">
                           <table class="table table-borderless table-sm table-nowrap align-middle mb-0">
                              <tbody>
                                 <tr>
                                    <th scope="row">Sub Total</th>
                                    <td style="width:150px;">
                                       <input type="text" name="cart-subtotal" class="form-control bg-light border-0" id="cart-subtotal" placeholder="Ksh 0.00" value="Ksh {{ old('cart-subtotal') ? old('card-subtotal') : $invoice->amount }}" readonly />
                                    </td>
                                 </tr>
                                 <tr class="border-top border-top-dashed">
                                    <th scope="row">Total Amount</th>
                                    <td>
                                       <input type="text" name="cart-total" class="form-control bg-light border-0" id="cart-total" placeholder="Ksh 0.00" value="Ksh {{ old('cart-total')? old('cart-total') : $invoice->amount }}" readonly />
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                           <!--end table-->
                        </td>
                     </tr>
                  </table>
                  <!--end table-->
               </div>
               <!--end row-->
               <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                  <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Save invoice</button>
                  <a href="{{ route('invoice.index') }}" class="btn btn-danger"><i class="ri-close-line align-bottom"></i></a>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
{{-- <script src="{{URL::asset('assets/libs/cleave.js/cleave.js.min.js')}}"></script> --}}
<script src="{{URL::asset('assets/js/pages/invoicecreate.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection