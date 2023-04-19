// get necessary elements
const input = document.querySelectorAll("#number");

const bookPrice = document.querySelectorAll("#bookPrice");

const result = document.querySelectorAll('#total');

const cartTotal = document.getElementById('cartTotal'); 

// Utility functions
function roundNumber(number) {
    return Math.round(number * 100)/100;
}

function totalPrice (bookPrice, number) {
    return roundNumber(parseFloat(bookPrice)*parseFloat(number));
}

// handle inputs fields and update total price of every line
function handleInputs (e,i) {
    
    result[i].innerHTML = totalPrice(bookPrice[i].innerHTML,e);

    if(!e){
        result[i].innerHTML = 0;
    }
    updateCartTotal()
}

// update total price of cart
function updateCartTotal(){
    const numbers = [];
    result.forEach(elt => {
        numbers.push(parseFloat(elt.textContent));
    });
    const sum = roundNumber(numbers.reduce((a,c)=>a+c,0));
    cartTotal.innerHTML = sum;
}

// add event listener to inputs
for(let i = 0; i < input.length; i++) {
    input[i].addEventListener('input', (e) => handleInputs(e.target.value,i))
}

// on page load, update the price of each line
$('*[id*=total]:visible').each(function(i) {
   $(this).text(totalPrice(input[i].value, bookPrice[i].innerHTML));
});

// on page load, update the total price of cart
$('#cartTotal').load(updateCartTotal());