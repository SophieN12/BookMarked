document.getElementById("create-account-form").addEventListener("submit", addUser);

async function addUser(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    formData.set('createAccountBtn', true);

    try {
        const response = await fetch('../create-user.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        console.log(data);

        // $('#success').html(data['successMessage']);
        // $('#error').html(data['errorMessages']);

        // if (!$('#success').is(':empty')) {
        //     $('#create-account-form')[0].reset();
        // }
    } catch (error) {
        console.log(error);
    }
}
