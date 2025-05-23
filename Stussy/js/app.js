paypal
    .Buttons({
        createOrder: function (data, actions) {
            // Set the amount dynamically from the hidden input field
            const amount = $('#total_price').val();
            return actions.order.create({
                purchase_units: [
                    {
                        amount: {
                            value: amount, // Use dynamic amount
                            currency_code: 'USD', // Change currency as needed
                        },
                    },
                ],
            });
        },
        onApprove: function (data, actions) {
            // Handle when the payment is approved
            return actions.order.capture().then(function (details) {
                // Show a success message to the user
                const transaction = details.purchase_units[0].payments.captures[0];
                //alert(transaction.status + ' => ' + transaction.id)
                //How to insert the response into the database using PHP
                var user_id = userId; // dynamically set from checkout.php

                $.ajax({
                    method: "POST",
                    url: "paypal_processor.php",
                    data: {transaction_id: transaction.id, user: user_id, transaction_status: transaction.status},
                    success: function(response) {
                        if(response == 1) {
                            alert("Payment Successfull. Transaction ID is " + transaction.id)
                        } else {
                            alert('Failed to process payment')
                            console.log(response)
                        }
                    }
                })

                //alert('Transaction completed by ' + details.payer.name.given_name + '. Payment successful');
            });
        },
        onError: function (error) {
            // Handle errors and display an error message to the user
            console.log(error);
            alert(error + 'An error occurred while processing the payment. Please try again later.');
        },
    })
    .render('#paypal-button-container'); 
// Render the PayPal button in the specified container
