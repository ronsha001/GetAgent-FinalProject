const price_input = document.getElementById("price"),
hidden_price = document.getElementById("hidden_price");

price_input.addEventListener('input', inputHandler);

function inputHandler(){
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