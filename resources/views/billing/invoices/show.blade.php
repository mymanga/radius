<!DOCTYPE html>
<html class="no-js" lang="en">
   <head>
      <!-- Meta Tags -->
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Site Title -->
      <title>Invoice</title>
      <link rel="stylesheet" href="{{URL::asset('assets/invoice/css/style.css')}}">
   </head>
   <body>
      <div class="cs-container">
         <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
               <div class="cs-invoice_head cs-type1 cs-mb25">
                  <div class="cs-invoice_left">
                     <p class="cs-invoice_number cs-primary_color cs-mb0 cs-f16"><b class="cs-primary_color">Invoice No:</b> {{$invoice->invoice_number}}</p>
                  </div>
                  @if(setting('logo') && File::exists(setting('logo')))
                  <div class="cs-invoice_right cs-text_right">
                     <div class="cs-logo cs-mb5">
                        <img style="max-height:50px" src="{{ asset(setting('logo')) }}" alt="Logo">
                     </div>
                  </div>
                  @endif
               </div>
               <div class="cs-invoice_head cs-mb10">
                  <div class="cs-invoice_left">
                     <b class="cs-primary_color">Invoice To:</b>
                     <p>
                        {{$invoice->user->fullName()}} <br>
                        {{$invoice->user->location}} <br>
                        {{$invoice->user->email}} <br>
                        {{$invoice->user->phone}}
                     </p>
                  </div>
                  <div class="cs-invoice_right cs-text_right">
                     <b class="cs-primary_color">{{setting('company')}}</b>
                     <p>
                        {{setting('city')}}<br>
                        {{setting('company_email')}} <br>
                        {{setting('company_phone')}}
                     </p>
                  </div>
               </div>
               <ul class="cs-list cs-style2">
                  <li>
                     <div class="cs-list_left">Client Number: <b class="cs-primary_color cs-semi_bold ">{{$invoice->user->username}}</b></div>
                     <div class="cs-list_right">Outstanding Balance: <b class="cs-primary_color cs-semi_bold "> 
                        @if($invoice->status == 'unpaid' || $invoice->status == 'canceled')
                        Ksh {{$invoice->amount}}
                        @else
                        Ksh 0
                        @endif 
                        </b>
                     </div>
                  </li>
                  <li>
                     <div class="cs-list_left">Invoice Date: <b class="cs-primary_color cs-semi_bold ">{{$invoice->created_at->format('d M Y')}}</b></div>
                     {{-- 
                     <div class="cs-list_right">Total Curent Charges: <b class="cs-primary_color cs-semi_bold ">25 Feb 2022</b></div>
                     --}}
                  </li>
                  <li>
                     <div class="cs-list_left">Due Date: <b class="cs-primary_color cs-semi_bold ">{{ Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</b></div>
                     <div class="cs-list_right">Status: <b class="cs-primary_color cs-semi_bold "> 
                        @if($invoice->status == 'unpaid')
                        <span style="color:#FFA500">{{$invoice->status}}</span>
                        @elseif($invoice->status == 'canceled')
                        <span style="color:#f03710">{{$invoice->status}}</span>
                        @else
                        <span style="color:#10b0f0">{{$invoice->status}}</span>
                        @endif 
                        </b>
                     </div>
                  </li>
               </ul>
               @if($invoice->creditnotes->count() > 0)
               <div class="cs-table cs-style1 cs-accent_10_bg cs-mb30">
                  <div class="cs-table_responsive">
                     <table class="cs-border_less">
                        <tbody>
                           <tr>
                              <td class="cs-width_4 cs-text_center">
                                 <p class="cs-accent_color cs-m0 cs-bold cs-f16 cs-special_item">Adjustment</p>
                                 <p class="cs-m0">Credit Notes</p>
                              </td>
                              <td class="cs-width_8">
                                 <div class="cs-table cs-style1">
                                    <table>
                                       <tbody>
                                          <tr>
                                             <td class="cs-primary_color cs-semi_bold">Note Number</td>
                                             <td class="cs-primary_color cs-semi_bold">Details</td>
                                             <td class="cs-primary_color cs-semi_bold">Amount</td>
                                          </tr>
                                          @foreach($invoice->creditnotes as $note)
                                          <tr>
                                             <td>{{ $note->credit_note_number }}</td>
                                             <td>{{ $note->details }}</td>
                                             <td>{{ $note->amount }}</td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                    </table>
                                 </div>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               @endif
               <div class="cs-table cs-style1">
                  <div class="cs-round_border">
                     <div class="cs-table_responsive">
                        <table>
                           <thead>
                              <tr>
                                 <th class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Item</th>
                                 <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">Description</th>
                                 <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Qty</th>
                                 <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">Price</th>
                                 <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($invoice->invoice_items as $item)
                              <tr>
                                 <td class="cs-width_3">{{ $item->name }}</td>
                                 <td class="cs-width_4">{{ $item->details }}</td>
                                 <td class="cs-width_2">{{ $item->quantity }}</td>
                                 <td class="cs-width_1">{{ $item->rate }}</td>
                                 <td class="cs-width_2 cs-text_right">{{ $item->price }}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                     <div class="cs-invoice_footer cs-border_top">
                        <div class="cs-left_footer cs-mobile_hide">
                           
                           <p class="cs-mb0"><b class="cs-primary_color">Payment details</b></p>
                           <p class="cs-m0">Paybill number: {{ config('mpesa.credentials.shortcode') }} <br>Account number: {{ $invoice->user->username }}</p>
                          
                        </div>
                        <div class="cs-right_footer">
                           <table>
                              <tbody>
                                 <tr class="cs-border_left">
                                    <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Subtotal</td>
                                    <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">Ksh {{ $invoice->amount }}</td>
                                 </tr>
                                 <tr class="cs-border_left">
                                    <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Total</td>
                                    <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">Ksh {{ $invoice->amount }}</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
            <div class="cs-invoice_btns cs-hide_print">
               <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                     <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                     <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                     <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                     <circle cx="392" cy="184" r="24"/>
                  </svg>
                  <span>Print</span>
               </a>
               <button id="download_btn" class="cs-invoice_btn cs-color2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                     <title>Download</title>
                     <path d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 272l80 80 80-80M256 48v288"/>
                  </svg>
                  <span>Download</span>
               </button>
            </div>
         </div>
      </div>
      <script src="{{URL::asset('assets/invoice/js/jquery.min.js')}}"></script>
      <script src="{{URL::asset('assets/invoice/js/jspdf.min.js')}}"></script>
      <script src="{{URL::asset('assets/invoice/js/html2canvas.min.js')}}"></script>
      <script src="{{URL::asset('assets/invoice/js/main.js')}}"></script>
   </body>
</html>