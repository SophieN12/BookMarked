const filterMenu = document.getElementById("filter-menu");
const filters = document.getElementsByClassName("dropdown-item");

console.log(filters);

for (let filter of filters) {
    filter.addEventListener("click", filtering)
}
async function filtering(e) {
    e.preventDefault();
    const clickedItem = e.target;
    console.log(clickedItem);
}

