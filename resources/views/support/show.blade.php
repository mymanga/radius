@extends('layouts.master') @section('title') messages @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">#{{ $conversation->id }} - {{ $conversation->subject }}</h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="{{ route('support.index') }}">Tickets</a></li>
            </ol>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4 mb-n5">
         <div class="bg-soft-info">
            <div class="card-body pb-4 mb-5">
               <div class="row">
                  <div class="col-md">
                     <div class="row align-items-center">
                        <div class="col-md-auto">
                           <div class="avatar-md mb-md-0 mb-4">
                              <div class="avatar-title bg-white rounded-circle">
                                 {{-- <img src="assets/images/companies/img-4.png" alt="" class="avatar-sm" /> --}}
                                 <img src="https://www.gravatar.com/avatar/{{ md5($conversation->from) }}?d=identicon" alt="" class="avatar-sm" />
                              </div>
                           </div>
                        </div>
                        <div class="col-md">
                           <h4 class="fw-semibold" id="ticket-title">{{ $conversation->from }} @if($conversation->user) <code>[{{$conversation->user->username}}]</code> @endif</h4>
                           <div class="hstack gap-3 flex-wrap">
                              @if($conversation->user)
                              <div class="text-muted user-div">
                                 User : 
                                 <span class="fw-medium">
                                 {{ $conversation->user->firstname }} {{ $conversation->user->lastname }}
                                 </span>
                              </div>
                              <div class="vr"></div>
                              @endif
                              <div class="text-muted">
                                 Date Created : 
                                 <span class="fw-medium" id="create-date">{{ $conversation->created_at->format('d M, Y') }}</span>
                              </div>
                              <div class="vr"></div>
                              <span id="status-badge">{!! $conversation->status_badge !!}</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-8">
      <!-- Main content area -->
      <div class="card">
         <div class="card-body content-card">
            <div style="width:100%">
               <div id="shadow-host" class="table-wrapper"></div>
            </div>
            @if($conversation->replies->isNotEmpty()) <!-- Check if there are any replies -->
            <div class="my-4">
               <h3 class="fw-semibold text-uppercase mb-3">Reply Thread</h3>
               @foreach($conversation->replies as $reply)
               <hr>
               <div>
                  <strong>Reply ({{ $reply->created_at }})</strong><br>
                  {!! $reply->body !!} 
               </div>
               @endforeach
            </div>
            @endif
         </div>
         <!--end card-body-->
         <div class="card-body p-4">
            <form action="{{ route('support.respond', $conversation) }}" method="POST" class="mt-3">
               @csrf
               <div class="row g-3">
                  <div class="col-lg-12">
                     <label for="body" class="form-label">Your Reply</label>
                     <textarea name="body" id="body" rows="3" class="form-control bg-light border-light" placeholder="Enter reply"></textarea>
                  </div>
                  <div class="col-lg-12 text-end">
                     <button type="submit" class="btn btn-info">Send Reply</button>
                  </div>
               </div>
            </form>
         </div>
         <!--end card-body-->
      </div>
      <!--end card-->
   </div>
   <div class="col-lg-4">
      <!-- Sidebar for conversation details and status update -->
      <div class="card">
         {{-- <div class="card-header">
            <h5 class="card-title mb-0">Ticket Details</h5>
         </div> --}}
         <div class="card-body">
            <div class="table-responsive table-card">
               <table class="table table-borderless align-middle mb-0">
                  <tbody>
                     <tr>
                        <td class="fw-medium">Ticket</td>
                        <td>#{{ $conversation->id }}</td>
                     </tr>
                     <tr>
                        <td class="fw-medium">From</td>
                        <td id="t-client" style="word-break: break-word; max-width: 100%;">
                           {{ $conversation->from }}
                           @if(empty($conversation->user_id))
                           <button type="button" class="btn btn-link" id="attachToUserBtn">Attach to User</button>
                           @endif
                        </td>
                     </tr>
                     <!-- Add more details as per your data structure -->
                     <tr>
                        <td class="fw-medium">Status:</td>
                        <td>
                           <form id="statusForm" action="{{ route('support.updateStatus', $conversation) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <select class="form-select" id="t-status" name="status" aria-label="Default select example">
                              <option value="new" @if($conversation->status == 'new') selected @endif>New</option>
                              <option value="pending" @if($conversation->status == 'pending') selected @endif>Pending</option>
                              <option value="solved" @if($conversation->status == 'solved') selected @endif>Solved</option>
                              </select>
                           </form>
                        </td>
                     </tr>
                     <!-- Add more details here -->
                     <tr>
                        <td class="fw-medium">Date Created</td>
                        <td id="c-date">{{ $conversation->created_at->format('d M, Y') }}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Bootstrap Modal -->
   <!--end col-->
</div>
<div class="modal fade" id="attachToUserModal" tabindex="-1" aria-labelledby="attachToUserModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="attachToUserModalLabel">Attach to User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <input type="text" id="user-search-input" class="form-control" placeholder="Search for a user">
            <!-- Place for the user list table -->
            <div id="user-list-container"></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="searchUserBtn">Search</button>
            <button type="button" class="btn btn-success" id="attachUserBtn">Attach</button>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script>
   var clean_html = `{!! $clean_html !!}`;
   var csrf_token = '{{ csrf_token() }}';
   var conversation_id = '{{ $conversation->id }}';
   var searchUserUrl = "{{ route('support.searchUser') }}";
   var attachToTicketUrl = "{{ route('support.attachToUser') }}";
</script> --}}
{{-- <script src="{{ URL::asset('/assets/js/supportshow.js') }}"></script> --}}
<script>
   var clean_html = `{!! $clean_html !!}`;
    var csrf_token = '{{ csrf_token() }}';
    var conversation_id = '{{ $conversation->id }}';
    var searchUserUrl = "{{ route('support.searchUser') }}";
    var attachToTicketUrl = "{{ route('support.attachToUser') }}";
   
   var selectedUserId = null;
   
   document.addEventListener('DOMContentLoaded', () => {
   handleShadowRoot();
   handleStatusChangeWithJQuery();
   handleAttachToUser();
   });
   
   function handleShadowRoot() {
   const shadowHost = document.querySelector("#shadow-host");
   const shadowRoot = shadowHost.attachShadow({
      mode: "open"
   });
   
   const style = document.createElement('style');
   style.textContent = `
        :host {
            {{-- all: initial; --}}
        }
        table {
            width: 100%;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    `;
   shadowRoot.appendChild(style);
   shadowRoot.innerHTML += `{!! $clean_html !!}`;
   }
   
   function handleStatusChangeWithJQuery() {
   $('#t-status').change(function () {
      $.ajax({
         url: $('#statusForm').attr('action'),
         method: 'POST',
         data: $('#statusForm').serialize(),
         success: function (response) {
            console.log('Status updated successfully');
            $('#status-badge').html(response.badgeHtml);
         },
         error: function (response) {
            console.log('Error updating status');
         }
      });
   });
   }
   
   function handleAttachToUser() {
   var attachToUserBtn = document.querySelector('#attachToUserBtn');
   if (attachToUserBtn) {
      attachToUserBtn.addEventListener('click', () => {
         var modal = new bootstrap.Modal(document.getElementById('attachToUserModal'));
         modal.show();
      });
   
      // Event to reset the modal when it's closed
        $('#attachToUserModal').on('hidden.bs.modal', () => {
            selectedUserId = null; // Reset the selected user ID
            document.getElementById('user-list-container').innerHTML = ''; // Clear the user list HTML
            document.getElementById('user-search-input').value = ''; // Clear the search input field
        });
   
      document.getElementById('searchUserBtn').addEventListener('click', () => {
         var query = document.getElementById('user-search-input').value;
         fetch(`${searchUserUrl}?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
               if (data.length === 0) {
                  Swal.fire('Info', 'No users found', 'info');
                  return;
               }
               let userListHTML = '<table class="table">';
               userListHTML += '<thead><tr><th></th><th>First Name</th><th>Last Name</th></tr></thead><tbody>';
               data.forEach((user, index) => {
                  userListHTML += `<tr><td><input type="radio" name="user" value="${user.id}" onclick="setSelectedUserId(${user.id})"></td><td>${user.firstname}</td><td>${user.lastname}</td></tr>`;
               });
               userListHTML += '</tbody></table>';
   
               document.getElementById('user-list-container').innerHTML = userListHTML;
            })
            .catch(error => {
               console.error('Fetch Error:', error);
               Swal.fire('Error', 'An error occurred while fetching users', 'error');
            });
      });
   
      document.getElementById('attachUserBtn').addEventListener('click', () => {
         if (!selectedUserId) {
            Swal.fire('Warning', 'No user selected', 'warning');
            return;
         }
   
         fetch(attachToTicketUrl, {
               method: 'POST',
               headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
               },
               body: JSON.stringify({
                  userId: selectedUserId,
                  ticketId: '{{ $conversation->id }}'
               })
            })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  Swal.fire('Success', 'User attached to the ticket successfully', 'success').then(() => {
                     location.reload();
                  });
               } else {
                  Swal.fire('Error', 'Failed to attach user to the ticket', 'error');
               }
            })
            .catch(error => {
               console.error('Error:', error);
               Swal.fire('Error', 'An error occurred while attaching user to the ticket', 'error');
            });
      });
   } else {
      
   }
   }
   
   function setSelectedUserId(id) {
   selectedUserId = id;
   }
</script>
@endsection