var paymentSign = "Ksh ";
function otherPayment() {
    var e = document.getElementById("choices-payment-currency").value;
    (paymentSign = e),
        document.getElementsByClassName("product-line-price").forEach(function (e) {
            (isUpdate = e.value.slice(1)), (e.value = paymentSign + isUpdate);
        }),
        recalculateCart();
}
// var isPaymentEl = document.getElementById("choices-payment-currency"),
//     choices = new Choices(isPaymentEl, { searchEnabled: !1 });
function isData() {
    var e = document.getElementsByClassName("plus"),
        t = document.getElementsByClassName("minus");
    Array.from(e).forEach(function (n) {
        n.onclick = function (e) {
            var t;
            parseInt(n.previousElementSibling.value) < 100 && // Updated max quantity
                (e.target.previousElementSibling.value++,
                (t = n.parentElement.parentElement.previousElementSibling.querySelector(".product-price").value),
                (e = n.parentElement.parentElement.nextElementSibling.querySelector(".product-line-price")),
                updateQuantity(n.parentElement.querySelector(".product-quantity").value, t, e));
        };
    }),
    Array.from(t).forEach(function (n) {
        n.onclick = function (e) {
            var t;
            1 < parseInt(n.nextElementSibling.value) &&
                (e.target.nextElementSibling.value--,
                (t = n.parentElement.parentElement.previousElementSibling.querySelector(".product-price").value),
                (e = n.parentElement.parentElement.nextElementSibling.querySelector(".product-line-price")),
                updateQuantity(n.parentElement.querySelector(".product-quantity").value, t, e));
        };
    });
}
    
    flatpickr("#date-field", { enableTime: !0, dateFormat: "d M, Y, h:i K" }),
    isData();
var count = document.querySelectorAll('.product').length;

function new_link() {
    count++;
    var e = document.createElement("tr");
    e.id = count;
    e.className = "product";
    var t = 
        '<tr><th scope="row" class="product-id">' + count +
        '</th><td class="text-start"><div class="mb-2"><input class="form-control bg-light border-0" type="text" id="productName-' + count +
        '" name="products[' + count + '][name]" placeholder="Product Name"></div><textarea class="form-control bg-light border-0" id="productDetails-' + count +
        '" name="products[' + count + '][details]" rows="2" placeholder="Product Details"></textarea></div></td><td><input class="form-control bg-light border-0 product-price" type="number" id="productRate-' + count +
        '" name="products[' + count + '][rate]" step="0.01" placeholder="Ksh0.00"></td><td><div class="input-step"><button type="button" class="minus">–</button><input type="number" class="product-quantity" id="product-qty-' + count +
        '" name="products[' + count + '][quantity]" value="0" readonly><button type="button" class="plus">+</button></div></td><td class="text-end"><div><input type="text" class="form-control bg-light border-0 product-line-price" id="productPrice-' + count +
        '" name="products[' + count + '][price]" placeholder="Ksh0.00" /></div></td><td class="product-removal"><a class="btn btn-success">Delete</a></td></tr';
    e.innerHTML = document.getElementById("newForm").innerHTML + t;
    document.getElementById("newlink").appendChild(e);

    var n = document.querySelectorAll("[data-trigger]");
    for (i = 0; i < n.length; ++i) {
        var o = n[i];
        new Choices(o, { placeholderValue: "This is a placeholder set in the config", searchPlaceholderValue: "This is a search placeholder" });
    }

    isData(), remove(), amountKeyup(), resetRow();
}

remove();
var taxRate = 0.125,
    shippingRate = 65,
    discountRate = 0.15;
function remove() {
    document.querySelectorAll(".product-removal a").forEach(function (e) {
        e.addEventListener("click", function (e) {
            removeItem(e), resetRow();
        });
    });
}
function resetRow() {
    document
        .getElementById("newlink")
        .querySelectorAll("tr")
        .forEach(function (e, t) {
            t += 1;
            e.querySelector(".product-id").innerHTML = t;
        });
}
function recalculateCart() {
    var t = 0;
    Array.from(document.getElementsByClassName("product")).forEach(function (e) {
        Array.from(e.getElementsByClassName("product-line-price")).forEach(function (e) {
            if (e.classList.contains("product-line-price")) {
                t += parseFloat(e.value);
            } else {
                t += parseFloat(e.value.slice(paymentSign.length));
            }
        });
    });

    var a = t;

    (document.getElementById("cart-subtotal").value = paymentSign + t.toFixed(2)),
        (document.getElementById("cart-total").value = paymentSign + t.toFixed(2)), // No paymentSign here
        (document.getElementById("totalamountInput").value = a.toFixed(2)), // No paymentSign here
        (document.getElementById("amountTotalPay").value = a.toFixed(2)); // No paymentSign here
}


function amountKeyup() {
    document.getElementsByClassName("product-price").forEach(function (n) {
        n.addEventListener("keyup", function (e) {
            var t = n.parentElement.nextElementSibling.nextElementSibling.querySelector(".product-line-price");
            updateQuantity(e.target.value, n.parentElement.nextElementSibling.querySelector(".product-quantity").value, t);
        });
    });
}
function updateQuantity(e, t, n) {
    // Check if e and t are numbers
    if (isNaN(e) || isNaN(t)) {
        // One or both are not numbers - skip this calculation
        return;
    }

    // Convert e and t to float
    e = parseFloat(e);
    t = parseFloat(t);

    // Perform the calculation
    t = (t = e * t).toFixed(2);
    
    // Removes the "Ksh" sign only for productPrice
    if (n.classList.contains("product-line-price")) {
        n.value = t;
    } else {
        n.value = paymentSign + t;
    }
    
    recalculateCart();
}


function removeItem(e) {
    e.target.closest("tr").remove(), recalculateCart();
}
amountKeyup();
var genericExamples = document.querySelectorAll("[data-trigger]");
for (i = 0; i < genericExamples.length; ++i) {
    var element = genericExamples[i];
    new Choices(element, { placeholderValue: "This is a placeholder set in the config", searchPlaceholderValue: "This is a search placeholder" });
}
// var cleaveBlocks = new Cleave("#cardNumber", { blocks: [4, 4, 4, 4], uppercase: !0 }),
    genericExamples = document.querySelectorAll('[data-plugin="cleave-phone"]');
for (i = 0; i < genericExamples.length; ++i) {
    element = genericExamples[i];
    new Cleave(element, { delimiters: ["(", ")", "-"], blocks: [0, 3, 3, 4] });
}
let viewobj;
var value,
    invoices_list = localStorage.getItem("invoices-list"),
    options = localStorage.getItem("option"),
    invoice_no = localStorage.getItem("invoice_no"),
    invoices = JSON.parse(invoices_list);
if (
    (null === localStorage.getItem("invoice_no") && null === localStorage.getItem("option")
        ? ((viewobj = ""), (value = "SP-" + Math.floor(11111111 + 99999999 * Math.random())), (document.getElementById("invoicenoInput").value = value))
        : (viewobj = invoices.find((e) => e.invoice_no === invoice_no)),
    "" != viewobj && "edit-invoice" == options)
) {
        new Cleave("#compnayContactno", { prefix: viewobj.company_details.contact_no, delimiters: ["(", ")", "-"], blocks: [0, 3, 3, 4] }),
    "" !== viewobj.img && (preview.src = viewobj.img),
        (document.getElementById("invoicenoInput").value = "#VAL" + viewobj.invoice_no),
        document.getElementById("invoicenoInput").setAttribute("readonly", !0),
        (document.getElementById("date-field").value = viewobj.date),
        (document.getElementById("choices-payment-status").value = viewobj.status),
        (document.getElementById("totalamountInput").value = "Ksh" + viewobj.order_summary.total_amount),
        (document.getElementById("shippingName").value = viewobj.shipping_address.full_name),
        new Cleave("#shippingPhoneno", { prefix: viewobj.company_details.contact_no, delimiters: ["(", ")", "-"], blocks: [0, 3, 3, 4] }),
        (document.getElementById("shippingTaxno").value = viewobj.billing_address.tax);
    for (var paroducts_list = viewobj.prducts, counter = 1; counter++, 1 < paroducts_list.length && document.getElementById("add-item").click(), paroducts_list.length - 1 >= counter; );
    var counter_1 = 1;
    setTimeout(() => {
        paroducts_list.forEach(function (e) {
            (document.getElementById("productName-" + counter_1).value = e.product_name),
                (document.getElementById("productDetails-" + counter_1).value = e.product_details),
                (document.getElementById("productRate-" + counter_1).value = e.rates),
                (document.getElementById("product-qty-" + counter_1).value = e.quantity),
                (document.getElementById("productPrice-" + counter_1).value = "Ksh" + e.rates * e.quantity),
                counter_1++;
        });
    }, 300),
        (document.getElementById("cart-subtotal").value = "Ksh" + viewobj.order_summary.sub_total),
        (document.getElementById("cart-total").value = "Ksh" + viewobj.order_summary.total_amount),
        (document.getElementById("choices-payment-type").value = viewobj.payment_details.payment_method),
    (document.getElementById("amountTotalPay").value = "Ksh" + viewobj.order_summary.total_amount), (document.getElementById("exampleFormControlTextarea1").value = viewobj.notes);
}
