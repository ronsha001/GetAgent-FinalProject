const price_input = document.getElementById("price");
const tax_input = document.getElementById("tax");

tax_input.addEventListener('input', taxHandler);
price_input.addEventListener('input', priceHandler);

function priceHandler(){
    const LENGTH = price_input.value.length;
    var value = price_input.value;
    var str_num = "";

    if (LENGTH > 0){
        for(var i = 0; i < LENGTH; i++){
            if (value[i] == '0' || value[i] == '1' || value[i] == '2' || value[i] == '3' || value[i] == '4' || value[i] == '5' || value[i] == '6' || value[i] == '7' || value[i] == '8' || value[i] == '9'){
                str_num += value[i];
            }
        }
        var x = parseInt(str_num);

        var str = x.toLocaleString("en-US");
        price_input.value = str;
    }
}
function taxHandler(){
    const LENGTH = tax_input.value.length;
    var value = tax_input.value;
    var str_num = "";

    if (LENGTH > 0){
        for(var i = 0; i < LENGTH; i++){
            if (value[i] == '0' || value[i] == '1' || value[i] == '2' || value[i] == '3' || value[i] == '4' || value[i] == '5' || value[i] == '6' || value[i] == '7' || value[i] == '8' || value[i] == '9'){
                str_num += value[i];
            }
        }
        var x = parseInt(str_num);

        var str = x.toLocaleString("en-US");
        tax_input.value = str;
    }
}