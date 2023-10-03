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
    
    if (shadowHost) {
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
         shadowRoot.innerHTML += clean_html;
     } else {
         console.error('Element with ID "shadow-host" not found');
     }
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

var selectedUserId = null;
console.log('searchUserUrl:', searchUserUrl);


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
