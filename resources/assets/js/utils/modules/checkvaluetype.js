var check_value_type = {
    methods:{
        isObject( obj ) {
        	return toString.call(obj) === "[object Object]"
     	},
     	isArray( obj ) {
	        return toString.call(obj) === "[object Array]"
	    },
    }
}
export default check_value_type