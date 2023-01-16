let modalToggleButtons = document.getElementsByClassName("modalBtn");
console.log(modalToggleButtons);
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
                document.getElementById("order-items-tbl").innerHTML += ` <tr>
                                                                                <td>${orderItems[i]['product_id']}</td>
                                                                                <td><img src="../products/${orderItems[i]['img_url']}" width="75px"></td>
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

$('#adminOrderModal').on('hide.bs.modal', function () {
    document.getElementById("order-items-tbl").innerHTML = `
                                                                <th>ID:</th>
                                                                <th>Produktbild:</th>
                                                                <th>Produkt:</th>
                                                                <th>Pris</th>
                                                                <th>Antal:</th>`
})
