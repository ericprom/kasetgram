import moment from 'moment'
var date_format = {
    methods:{
        displayDate(date) {
	        return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
	  	},
	 	saveDate(date) {
	        return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
	   	},
	   	dateFilter(option) {
		    var result = {
		      start: moment().startOf('month').format("DD/MM/YYYY"),
		      end: moment().endOf('month').format("DD/MM/YYYY")
		    }
		    switch (option) {
		      case 'today':
		        result.start = moment().startOf('day').format("DD/MM/YYYY");
		        result.end = moment().endOf('day').format("DD/MM/YYYY");
		        break;
		      case 'yesterday':
		        result.start = moment().startOf('day').subtract(1, "day").format("DD/MM/YYYY");
		        result.end = moment().endOf('day').subtract(1, "day").format("DD/MM/YYYY");
		        break;
		      case 'this_month':
		        result.start = moment().startOf('month').format("DD/MM/YYYY");
		        result.end = moment().endOf('month').format("DD/MM/YYYY");
		        break;
		      case 'last_month':
		        result.start = moment().startOf('month').subtract(1, "month").format("DD/MM/YYYY");
		        result.end = moment().endOf('month').subtract(1, "month").format("DD/MM/YYYY");
		        break;
		      case 'next_month':
		        result.start = moment().startOf('month').add(1, 'month').format("DD/MM/YYYY");
		        result.end = moment().endOf('month').add(1, 'month').format("DD/MM/YYYY");
		        break;
		      case 'custom':
		        break;
		      default:
		          result.start = moment().startOf('month').format("DD/MM/YYYY");
		          result.end =  moment().endOf('month').format("DD/MM/YYYY");
		          break;
		    }

		    return result;
		}
    }
}
export default date_format