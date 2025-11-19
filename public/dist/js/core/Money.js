
var Money = {

    toBR: function (num) {

        var x = 0;

        if(num<0){
            num = Math.abs(num);
            x = 1;
        }
        if(isNaN(num)){
            num = "0";
        }
        var cents = Math.floor((num*100+0.5)%100);

        num = Math.floor((num*100+0.5)/100).toString();

        if(cents < 10)
            cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
            num = num.substring(0,num.length-(4*i+3)) + '.' + num.substring(num.length-(4*i+3));

        var ret = num + ',' + cents;

        if (x == 1)
            ret = ' - ' + ret;

        return ret;
    },
    toFloat: function (s) {

        s = new String(s);

        for (var i = 0; i <= s.length; i++) {

            s = s.replace(".", "");
        }

        s = s.replace(",", ".");

        s = parseFloat(s);

        return (isNaN(s)) ? 0 : s;
    },
    getPercentual : function(valor, indice) {

        valor = valor / 100;
        valor = valor * indice;
        return parseFloat(valor);
    }
}