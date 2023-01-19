let modalToggleButtons = document.getElementsByClassName("modalBtn");
for (let modalToggleBtn of modalToggleButtons) {
    modalToggleBtn.addEventListener('click', fetchOrder)
}

async function fetchOrder(e) {
    orderId = e.target.dataset.whatever;

    try {
        let response = await fetch('specific-order.php?orderId='+ orderId);
        const data = await response.json();

        let orderItems = (data['orderItems']);
        if (data['status']) {
            for(let i = 0; i < orderItems.length; i++){
                document.querySelector('#order-items-table tbody').innerHTML += ` <tr>
                                                                                <td>${orderItems[i]['product_id']}</td>
                                                                                <td><img src="../admin/products/${orderItems[i]['img_url']}" width="75px"></td>
                                                                                <td>${orderItems[i]['product_title']}</td>
                                                                                <td>${orderItems[i]['unit_price']} SEK</td>
                                                                                <td>${orderItems[i]['quantity']} st</td>
                                                                            </tr>`
            }
        } else {
           console.log("status is false");
        }
    } catch(error) {
        console.log(error);
    }
}

$('#orderModal').on('hide.bs.modal', function () {
    document.querySelector('#order-items-table thead').innerHTML = `
                                                                <th>ID:</th>
                                                                <th>Produktbild:</th>
                                                                <th>Produkt:</th>
                                                                <th>Pris</th>
                                                                <th>Antal:</th>`
})
