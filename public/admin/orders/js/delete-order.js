let deleteButtons = document.getElementsByClassName('delete-order-form')

for (let deleteButton of deleteButtons) {
    deleteButton.addEventListener('submit', deleteOrder)
}

async function deleteOrder(e) {
    e.preventDefault();

    let orderId = e.target.firstElementChild.value;

    try {
        let response = await fetch('delete-order.php?orderId=' + orderId);
        const data = await response.json();

        e.target.parentNode.parentNode.remove();

        if (data['status']) {
            document.getElementById("messages").innerHTML = ` 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data['message']}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        } else {
            document.getElementById("messages").innerHTML = ` 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${data['message']}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
        }

    } catch (error) {
        console.log(error)
    }
}