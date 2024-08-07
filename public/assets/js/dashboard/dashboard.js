function fetchDashboardStats(url) {
    $(document).ready(function () {

        $.ajax({
                 url: url,
                 type: "GET",
                 dataType: "json",
                 success: function (response) {
                     // Get and set variables for use
                     var totaldata = response.totaldata;
                     var onlinesessions = response.onlinesessions;
                     var cpuload = response.cpuload;
                     var services = response.services;
                     var upload = response.totalupload;
                     var download = response.totaldownload;
                     var payments = response.payments;
                     var monthpayments = response.monthpayments;
                     var loadtime = response.loadtime;
                     var inactive = response.inactive;
                     var totalclients = response.totalclients;
                     var activePppoes = response.activePppoes;
                     var activeVouchers = response.activeVouchers;
                     var memusage = response.memusage;
                     var memtotal = response.memtotal;
                     var memused = response.memused;
                     var memavailable = response.memavailable;
                     var diskusage = response.diskusage;
                     var connections = response.connections;
                     var totalconnections = response.totalconnections;
                     var diskfree = response.diskfree;
                     var diskused = response.diskused;
                     var disktotal = response.disktotal;
                     var phpload = response.phpload;
                     var total_time = response.total_time;
                     var totalExpiringAmount = response.totalExpiringAmount;
                     var totalDormantAmount = response.totalDormantAmount;
                     var totalNewAmount = response.totalNewAmount;
                     var servicesExpiringToday = response.services_expiring_today.length;
                     var servicesDormant = response.services_dormant.length;
                     var servicesCreatedThisMonth = response.services_created_this_month.length;
                     var unpaidInvoices = response.unpaidInvoices;
                     var totalInvoiceAmount = response.totalInvoiceAmount;
    
                     // Auto update total clients
                     $("#totalclients").empty();
                     $("#totalclients").append(totalclients);
    
                     // Auto update consumed data section
                     $("#consumed_data").empty();
                     $("#consumed_data").append(totaldata);
    
                     // Auto update online sessions data sections
                     $("#onlinesessions").empty();
                     $("#onlinesessions").append(onlinesessions);
                     $("#online").empty();
                     $("#online").append(onlinesessions);
    
                     // Auto update CPU usage data section
                     $("#cpuload").empty();
                     $("#cpuload").append(cpuload);
                     document.getElementById('cpu_progress').style.width = cpuload + '%';
    
                     // Auto update active services data section
                     $("#activeservices").empty();
                     $("#activeservices").append(services);
    
                     // Auto update upload and download section
                     $("#upload").empty();
                     $("#upload").append(upload);
                     $("#download").empty();
                     $("#download").append(download);
    
                     // Auto update the payments
                     $("#payments").empty();
                     $("#payments").append(payments);
                     $("#monthpayments").empty();
                     $("#monthpayments").append(monthpayments);
    
                     // Auto update load time
                     $("#loadtime").empty();
                     $("#loadtime").append(loadtime);
    
                     // Auto update inactive clients
                     $("#inactiveservices").empty();
                     $("#inactiveservices").append(inactive);
    
                     // Auto update active pppoes data section
                     $("#pppoe").empty();
                     $("#pppoe").append(activePppoes);
    
                     // Auto update active hotspot data section
                     $("#hotspot").empty();
                     $("#hotspot").append(activeVouchers);
    
                     // Auto update memory usage
                     $("#memusage").empty();
                     $("#memusage").append(memusage);
    
                     // Auto update RAM total
                     $("#memtotal").empty();
                     $("#memtotal").append(memtotal);
    
                     // Auto update RAM used
                     $("#memused").empty();
                     $("#memused").append(memused);
    
                     // Auto update RAM available
                     $("#memavailable").empty();
                     $("#memavailable").append(memavailable);
    
                     // Auto update connections
                     $("#connections").empty();
                     $("#connections").append(connections);
    
                     // Auto update total connections
                     $("#totalconnections").empty();
                     $("#totalconnections").append(totalconnections);
    
                     // Auto update disk free
                     $("#diskfree").empty();
                     $("#diskfree").append(diskfree);
    
                     // Auto update disk used
                     $("#diskused").empty();
                     $("#diskused").append(diskused);
    
                     // Auto update disk total
                     $("#disktotal").empty();
                     $("#disktotal").append(disktotal);
    
                     // Auto update PHP load
                     $("#phpload").empty();
                     $("#phpload").append(phpload);
    
                     // Auto update total time
                     $("#total_time").empty();
                     $("#total_time").append(total_time);
    
                     // Auto update total expiring amount
                     $("#totalExpiringAmount").empty();
                     $("#totalExpiringAmount").append(response.totalExpiringAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update total dormant amount
                     $("#totalDormantAmount").empty();
                     $("#totalDormantAmount").append(response.totalDormantAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update total new amount
                     $("#totalNewAmount").empty();
                     $("#totalNewAmount").append(response.totalNewAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update services expiring today
                     $("#servicesExpiringToday").empty();
                     $("#servicesExpiringToday").append(response.services_expiring_today.length);
    
                     // Auto update services dormant
                     $("#servicesDormant").empty();
                     $("#servicesDormant").append(response.services_dormant.length);
    
                     // Auto update services created this month
                     $("#servicesCreatedThisMonth").empty();
                     $("#servicesCreatedThisMonth").append(response.services_created_this_month.length);

                     // Auto update Invoices section
                     $("#unpaidInvoices").empty();
                     $("#unpaidInvoices").append(unpaidInvoices);

                     $("#totalInvoiceAmount").empty();
                     $("#totalInvoiceAmount").append(totalInvoiceAmount);
    
                 },
                 error: function (err) {},
             });
    
        // Start the recurring Ajax requests
         setInterval(function () {
             $.ajax({
                 url: url,
                 type: "GET",
                 dataType: "json",
                 success: function (response) {
                     // Get and set variables for use
                     var totaldata = response.totaldata;
                     var onlinesessions = response.onlinesessions;
                     var cpuload = response.cpuload;
                     var services = response.services;
                     var upload = response.totalupload;
                     var download = response.totaldownload;
                     var payments = response.payments;
                     var monthpayments = response.monthpayments;
                     var loadtime = response.loadtime;
                     var inactive = response.inactive;
                     var totalclients = response.totalclients;
                     var activePppoes = response.activePppoes;
                     var activeVouchers = response.activeVouchers;
                     var memusage = response.memusage;
                     var memtotal = response.memtotal;
                     var memused = response.memused;
                     var memavailable = response.memavailable;
                     var diskusage = response.diskusage;
                     var connections = response.connections;
                     var totalconnections = response.totalconnections;
                     var diskfree = response.diskfree;
                     var diskused = response.diskused;
                     var disktotal = response.disktotal;
                     var phpload = response.phpload;
                     var total_time = response.total_time;
                     var totalExpiringAmount = response.totalExpiringAmount;
                     var totalDormantAmount = response.totalDormantAmount;
                     var totalNewAmount = response.totalNewAmount;
                     var servicesExpiringToday = response.services_expiring_today.length;
                     var servicesDormant = response.services_dormant.length;
                     var servicesCreatedThisMonth = response.services_created_this_month.length;
    
                     // Auto update total clients
                     $("#totalclients").empty();
                     $("#totalclients").append(totalclients);
    
                     // Auto update consumed data section
                     $("#consumed_data").empty();
                     $("#consumed_data").append(totaldata);
    
                     // Auto update online sessions data sections
                     $("#onlinesessions").empty();
                     $("#onlinesessions").append(onlinesessions);
                     $("#online").empty();
                     $("#online").append(onlinesessions);
    
                     // Auto update CPU usage data section
                     $("#cpuload").empty();
                     $("#cpuload").append(cpuload);
                     document.getElementById('cpu_progress').style.width = cpuload + '%';
    
                     // Auto update active services data section
                     $("#activeservices").empty();
                     $("#activeservices").append(services);
    
                     // Auto update upload and download section
                     $("#upload").empty();
                     $("#upload").append(upload);
                     $("#download").empty();
                     $("#download").append(download);
    
                     // Auto update the payments
                     $("#payments").empty();
                     $("#payments").append(payments);
                     $("#monthpayments").empty();
                     $("#monthpayments").append(monthpayments);
    
                     // Auto update load time
                     $("#loadtime").empty();
                     $("#loadtime").append(loadtime);
    
                     // Auto update inactive clients
                     $("#inactiveservices").empty();
                     $("#inactiveservices").append(inactive);
    
                     // Auto update active pppoes data section
                     $("#pppoe").empty();
                     $("#pppoe").append(activePppoes);
    
                     // Auto update active hotspot data section
                     $("#hotspot").empty();
                     $("#hotspot").append(activeVouchers);
    
                     // Auto update memory usage
                     $("#memusage").empty();
                     $("#memusage").append(memusage);
    
                     // Auto update RAM total
                     $("#memtotal").empty();
                     $("#memtotal").append(memtotal);
    
                     // Auto update RAM used
                     $("#memused").empty();
                     $("#memused").append(memused);
    
                     // Auto update RAM available
                     $("#memavailable").empty();
                     $("#memavailable").append(memavailable);
    
                     // Auto update connections
                     $("#connections").empty();
                     $("#connections").append(connections);
    
                     // Auto update total connections
                     $("#totalconnections").empty();
                     $("#totalconnections").append(totalconnections);
    
                     // Auto update disk free
                     $("#diskfree").empty();
                     $("#diskfree").append(diskfree);
    
                     // Auto update disk used
                     $("#diskused").empty();
                     $("#diskused").append(diskused);
    
                     // Auto update disk total
                     $("#disktotal").empty();
                     $("#disktotal").append(disktotal);
    
                     // Auto update PHP load
                     $("#phpload").empty();
                     $("#phpload").append(phpload);
    
                     // Auto update total time
                     $("#total_time").empty();
                     $("#total_time").append(total_time);
    
                     // Auto update total expiring amount
                     $("#totalExpiringAmount").empty();
                     $("#totalExpiringAmount").append(response.totalExpiringAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update total dormant amount
                     $("#totalDormantAmount").empty();
                     $("#totalDormantAmount").append(response.totalDormantAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update total new amount
                     $("#totalNewAmount").empty();
                     $("#totalNewAmount").append(response.totalNewAmount.toLocaleString('en-US', { maximumFractionDigits: 2 }));
    
                     // Auto update services expiring today
                     $("#servicesExpiringToday").empty();
                     $("#servicesExpiringToday").append(response.services_expiring_today.length);
    
                     // Auto update services dormant
                     $("#servicesDormant").empty();
                     $("#servicesDormant").append(response.services_dormant.length);
    
                     // Auto update services created this month
                     $("#servicesCreatedThisMonth").empty();
                     $("#servicesCreatedThisMonth").append(response.services_created_this_month.length);
    
                 },
                 error: function (err) {},
             });
         }, 5000);
     });
}