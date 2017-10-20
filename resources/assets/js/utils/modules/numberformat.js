import accounting from 'accounting-js'
var number_format = {
    methods:{
        formatNumber: function (number, config = { precision: 2, thousand: "," }) {
	      	return accounting.formatNumber(number, config)
	    },
        formatMoney: function (number, config =  { symbol: "฿",  format: "%v %s" }) {
	      	return accounting.formatMoney(number, config)
	    },
    }
}
export default number_format