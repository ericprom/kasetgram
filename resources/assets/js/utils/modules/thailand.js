var thailand = {
  	data () {
	    return {
	    	useLookup: null,
	    	lookup: null,
	    	words: null,
	      	data : this.thaiAddressExtract(require('../../../static/database/db.json'))
	    }
  	},
    methods:{
    	thaiAddressQuery(query) {
		    return this.data.filter((item) => {
		      return Object.keys(query).every(key => item[key].indexOf(query[key]) === 0)
		    })
		},
    	thaiAddressDecode(text) {
		    if (!this.useLookup) {
		      	return text
		    }

		    let newText = text

		    if (typeof text === 'number') {
		      	newText = this.lookup[text]
		    }

		    return newText.replace(/[A-Z]/ig, (m) => {
		      	const ch = m.charCodeAt(0)
		      	return this.words[ch < 97 ? ch - 65 : (26 + ch) - 97]
		    })
		},
        thaiAddressExtract(db) {
		    this.useLookup = db.lookup && db.words
		    const data = this.useLookup ? db.data : db

		    if (!data[0].length) {
		      return data
		    }

		    const result = []
		    this.lookup = this.useLookup ? db.lookup.split('|') : []
		    this.words = this.useLookup ? db.words.split('|') : []

		    data.forEach((province) => {
		      const hasGeoData = province.length === 3
		      const index = hasGeoData ? 2 : 1

		      province[index].forEach((district) => {
		        district[index].forEach((subdistrict) => {
		          (Array.isArray(subdistrict[index]) ? subdistrict[index] : [subdistrict[index]])
		            .forEach((zipcode) => {
		              const item = {
		                subdistrict: this.thaiAddressDecode(subdistrict[0]),
		                district: this.thaiAddressDecode(district[0]),
		                province: this.thaiAddressDecode(province[0]),
		                zipcode: `${zipcode}`,
		              };
		              if (hasGeoData) {
		                item.subdistrict_code = subdistrict[1] || false
		                item.district_code = district[1] || false
		                item.province_code = province[1] || false
		              }
		              result.push(item)
		            })
		        })
		      })
		    })

		    return result;
		}
    }
}
export default thailand