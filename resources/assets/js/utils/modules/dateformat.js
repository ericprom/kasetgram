import moment from 'moment'
var dateformat = {
    methods:{
        displayDate(date) {
	        return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
	  	},
	 	saveDate(date) {
	        return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
	   	}
    }
}
export default dateformat