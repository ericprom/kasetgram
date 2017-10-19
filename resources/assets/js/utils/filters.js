import moment from 'moment'
export function dateonly (value) {
  return moment(String(value)).format('DD/MM/YYYY')
}