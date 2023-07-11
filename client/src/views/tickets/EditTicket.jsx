import { useNavigate, useParams } from 'react-router-dom'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
import { useEvents } from '@/hooks/useEvents'
import { useTicketTypes } from '@/hooks/useTicketTypes'
import { useCurrencies } from '@/hooks/useCurrencies'
import { useUsers } from '@/hooks/useUsers'
import { useTicket } from '@/hooks/useTicket'
 
function EditEvent() {
  const params = useParams()
  const navigate = useNavigate()
  const { ticketTypes } = useTicketTypes()
  const { events } = useEvents()
  const { currencies } = useCurrencies()
  const { users } = useUsers()
  const { ticket, updateTicket } = useEvent(params.id)
  
 
  async function handleSubmit(e) {
    e.preventDefault()
 
    await updateTicket(ticket.data)
  }
 
  return (
    <form onSubmit={ handleSubmit } noValidate>
      <div className="">
 
        <h1 className="">Edit Event</h1>
 
        <div className="">
          <label htmlFor="ticket_type_id" className="required">Ticket Type</label>
          <select
            id="ticket_type_id"
            className=""
            value={ ticket.data.ticket_type_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              ticket_type_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { ticketTypes.length > 0 && ticketTypes.map((ticket_type) => {
              return <>
                <option key={ ticket_type.id } value={ ticket_type.id }>
                    { ticket_type.title.toUpperCase() }{' '}
                    { ticket_type.description }
                </option>
              </>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="ticket_type_id" />
        </div>
 
        <div className="">
          <label htmlFor="event_id" className="required">Event</label>
          <select
            id="event_id"
            className=""
            value={ ticket.data.event_id ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              event_id: e.target.value,
            }) }
            disabled={ ticket.loading }
          >
            { events.length > 0 && events.map((event) => {
              return <>
                <option key={ event.id } value={ event.id }>
                    { event.title.toUpperCase() }{' '}
                    { event.description }
                </option>
              </>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="event_id" />
        </div>
 
        <div className="">
          <label htmlFor="currency_id" className="required">Currency</label>
          <select
            id="currency_id"
            className=""
            value={ currency.data.currency_id ?? '' }
            onChange={ e => currency.setData({
              ...currency.data,
              currency_id: e.target.value,
            }) }
            disabled={ currency.loading }
          >
            { currencies.length > 0 && currencies.map((currency) => {
              return <>
                <option key={ currency.id } value={ currency.id }>
                    { currency.title.toUpperCase() }{' '}
                    { currency.description }
                </option>
              </>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="currency_id" />
        </div>
 
        <div className="">
          <label htmlFor="user_id" className="required">User</label>
          <select
            id="user_id"
            className=""
            value={ user.data.user_id ?? '' }
            onChange={ e => user.setData({
              ...user.data,
              user_id: e.target.value,
            }) }
            disabled={ user.loading }
          >
            { users.length > 0 && users.map((user) => {
              return <>
                <option key={ user.id } value={ user.id }>
                    { user.name }
                </option>
              </>
            }) }
          </select>
          <ValidationError errors={ ticket.errors } field="user_id" />
        </div>

        <div className="">
          <label htmlFor="amount_paid" className="">Amount_paid</label>
          <input
            id="amount_paid"
            name="amount_paid"
            type="text"
            value={ ticket.data.amount_paid ?? '' }
            onChange={ e => ticket.setData({
              ...ticket.data,
              amount_paid: e.target.value,
            }) }
            className=""
            disabled={ ticket.loading }
          />
          <ValidationError errors={ ticket.errors } field="amount_paid" />
        </div>
 
        <div className="">
          <button
            type="submit"
            className=""
            disabled={ ticket.loading }
          >
            { ticket.loading && <IconSpinner /> }
            Save Event
          </button>
 
          <button
            type="button"
            className=""
            disabled={ ticket.loading }
            onClick={ () => navigate(route('tickets.index')) }
          >
            <span>Cancel</span>
          </button>
        </div>
      </div>
    </form>
  )
}
 
export default EditEvent